<?php

namespace App\Http\Controllers;

use App\Models\PpksReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PpksController extends Controller
{
    public function loginForm()
    {
        if (Auth::guard('student')->check() && Auth::guard('student')->user()->is_active) {
            return redirect()->route('lapor.index');
        }

        return response()->view('pages.lapor.login')->header('Cache-Control', 'no-store, private');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'nim' => ['required', 'string', 'max:30'],
            'birth_date' => ['required', 'date_format:Y-m-d', 'before:today'],
        ]);

        $key = 'ppks-login:'.hash('sha256', $data['nim'].'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages(['nim' => 'Terlalu banyak percobaan. Coba lagi dalam '.RateLimiter::availableIn($key).' detik.']);
        }

        if (! Auth::guard('student')->attempt([
            'nim' => $data['nim'],
            'password' => $data['birth_date'],
            'is_active' => true,
        ])) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages(['nim' => 'NIM atau tanggal lahir tidak sesuai.']);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->route('lapor.index');
    }

    public function index()
    {
        $student = Auth::guard('student')->user();

        return view('pages.lapor.index', [
            'student' => $student,
            'reports' => $student->reports()->latest()->paginate(10),
        ]);
    }

    public function store(\App\Http\Requests\StorePpksReportRequest $request)
    {
        $report = app(\App\Services\SubmitPpksReport::class)->handle($request->validated(), $request->file('evidence', []), Auth::guard('student')->user());

        return redirect()->route('lapor.index')->with('success', 'Laporan berhasil dikirim. Nomor laporan: '.$report->reference);
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('lapor.login');
    }

    public function form()
    {
        return view('pages.lapor.form');
    }

    public function evidence(PpksReport $report, int $index)
    {
        $student = Auth::guard('student')->user();
        $publicReporter = Auth::guard('public_reporter')->user();
        $admin = Auth::guard('web')->user();
        $canAccessAsAdmin = $admin &&
            (! $admin instanceof \Filament\Models\Contracts\FilamentUser || $admin->canAccessPanel(\Filament\Facades\Filament::getPanel('admin'))) &&
            \App\Filament\Resources\PpksReportResource::canView($report);
        abort_unless($canAccessAsAdmin || ($publicReporter && $publicReporter->is_active && $report->reporter_type === 'public' && $publicReporter->id === $report->public_reporter_id) || ($student && $student->is_active && $student->id === $report->student_id), 404);

        $path = ($report->evidence_paths ?? [])[$index] ?? null;
        abort_unless($path && Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path, 'bukti-'.($index + 1).'.'.pathinfo($path, PATHINFO_EXTENSION), [
            'Cache-Control' => 'no-store, private',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
