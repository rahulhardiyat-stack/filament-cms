<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:newsletter_subscribers,email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        NewsletterSubscriber::create([
            'email' => $request->email,
            'is_active' => true,
            'subscribed_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Terima kasih! Anda telah berhasil subscribe newsletter kami.');
    }

    public function unsubscribe($email)
    {
        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if ($subscriber) {
            $subscriber->update(['is_active' => false]);
            return view('pages.newsletter-unsubscribe')
                ->with('success', 'Anda telah berhasil unsubscribe dari newsletter.');
        }

        return view('pages.newsletter-unsubscribe')
            ->with('error', 'Email tidak ditemukan.');
    }
}