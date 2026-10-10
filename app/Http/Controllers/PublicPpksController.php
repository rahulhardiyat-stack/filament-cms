<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePpksReportRequest;
use App\Models\PublicReporter;
use App\Services\SubmitPpksReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PublicPpksController extends Controller
{
    public function loginForm()
    {
        return $this->authForm('login');
    }

    public function registerForm()
    {
        return $this->authForm('register');
    }

    private function authForm(string $mode)
    {
        if (Auth::guard('public_reporter')->user()?->is_active) {
            return redirect()->route('lapor.public.index');
        }

        return response()->view('pages.lapor.public-auth', compact('mode'))->header('Cache-Control', 'no-store, private');
    }

    public function register(Request $request)
    {
        $request->merge(['username' => Str::lower(trim((string) $request->input('username')))]);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[a-z0-9_.]+$/', 'unique:public_reporters,username'],
            'password' => ['required', 'string', 'max:128', 'confirmed', Password::min(12)->letters()->numbers()],
        ]);
        $reporter = PublicReporter::create($data);
        Auth::guard('public_reporter')->login($reporter);
        $request->session()->regenerate();

        return redirect()->route('lapor.public.index')->with('success', 'Registrasi berhasil. Anda dapat mengirim laporan.');
    }

    public function login(Request $request)
    {
        $request->merge(['username' => Str::lower(trim((string) $request->input('username')))]);
        $data = $request->validate(['username' => ['required', 'string', 'max:50'], 'password' => ['required', 'string', 'max:128']]);
        $key = 'public-login:'.hash('sha256', $data['username'].'|'.$request->ip());
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages(['username' => 'Terlalu banyak percobaan. Coba lagi dalam '.RateLimiter::availableIn($key).' detik.']);
        }
        if (! Auth::guard('public_reporter')->attempt(array_merge($data, ['is_active' => true]))) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages(['username' => 'Username atau password tidak sesuai.']);
        }
        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->route('lapor.public.index');
    }

    public function index()
    {
        $reporter = Auth::guard('public_reporter')->user();

        return view('pages.lapor.public', ['reporter' => $reporter, 'reports' => $reporter->reports()->latest()->paginate(10)]);
    }

    public function store(StorePpksReportRequest $request, SubmitPpksReport $submit)
    {
        $report = $submit->handle($request->validated(), $request->file('evidence', []), Auth::guard('public_reporter')->user());

        return redirect()->route('lapor.public.index')->with('success', 'Laporan berhasil dikirim. Nomor laporan: '.$report->reference);
    }

    public function logout(Request $request)
    {
        Auth::guard('public_reporter')->logout();
        $request->session()->forget(['public_report_id', 'access_token']);
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('lapor.public.login');
    }
}
