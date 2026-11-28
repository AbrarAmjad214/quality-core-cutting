<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $success = 'Thank you! Your enquiry has been sent. Our team will contact you shortly.';

        // Honeypot: real visitors never fill the hidden "website" field.
        if (filled($request->input('website'))) {
            return $request->expectsJson()
                ? response()->json(['message' => $success])
                : back()->with('form_success', $success);
        }

        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:120'],
                'phone' => ['required', 'string', 'max:40', 'regex:/^[0-9+()\-\s]{7,}$/'],
                'email' => ['nullable', 'email', 'max:160'],
                'service' => ['nullable', 'string', 'max:80'],
                'message' => ['nullable', 'string', 'max:3000'],
                'page' => ['nullable', 'string', 'max:200'],
            ], [
                'phone.regex' => 'Please enter a valid phone number.',
            ]);
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Please check the highlighted fields.', 'errors' => $e->errors()], 422);
            }
            throw $e;
        }

        $serviceName = Content::service($data['service'] ?? '')['name'] ?? ($data['service'] ?? 'Not specified');

        $body = "New website enquiry\n\n"
            . "Name:    {$data['name']}\n"
            . "Phone:   {$data['phone']}\n"
            . 'Email:   ' . ($data['email'] ?? '-') . "\n"
            . "Service: {$serviceName}\n"
            . 'Page:    ' . ($data['page'] ?? '-') . "\n\n"
            . ($data['message'] ?? '');

        // Auto-reply to the client (only if they provided an email).
        if (! empty($data['email'])) {
            try {
                $autoReplyBody = view('emails.auto-reply', [
                    'name'    => $data['name'],
                    'service' => $serviceName !== 'Not specified' ? $serviceName : null,
                ])->render();

                Mail::html($autoReplyBody, function ($m) use ($data) {
                    $m->to($data['email'], $data['name'])
                        ->subject('Thank you for contacting ' . config('site.name') . ' — 24/7 Concrete Cutting Services');
                });
            } catch (\Throwable $e) {
                Log::error('Auto-reply email failed: ' . $e->getMessage());
            }
        }

        try {
            Mail::raw($body, function ($m) use ($data, $serviceName) {
                $m->to(config('site.enquiry_email'))->subject("Website enquiry: {$serviceName} — {$data['name']}");
                if (! empty($data['email'])) {
                    $m->replyTo($data['email'], $data['name']);
                }
            });
        } catch (\Throwable $e) {
            Log::error('Enquiry email failed: ' . $e->getMessage());
        }

        Log::channel('single')->info('Website enquiry', $data);

        // WhatsApp notification to Mr. Shahid via CallMeBot.
        $callMeBotApiKey = config('site.callmebot_api_key');
        if ($callMeBotApiKey) {
            try {
                $waMessage = "📩 New Enquiry!\n\n"
                    . "Name: {$data['name']}\n"
                    . "Phone: {$data['phone']}\n"
                    . 'Email: ' . ($data['email'] ?? '-') . "\n"
                    . "Service: {$serviceName}\n"
                    . 'Message: ' . (! empty($data['message']) ? $data['message'] : '-') . "\n\n"
                    . "Reply: {$data['phone']}";

                Http::get('https://api.callmebot.com/whatsapp.php', [
                    'phone'  => config('site.phone_raw'),
                    'text'   => $waMessage,
                    'apikey' => $callMeBotApiKey,
                ]);
            } catch (\Throwable $e) {
                Log::error('WhatsApp notification failed: ' . $e->getMessage());
            }
        }

        return $request->expectsJson()
            ? response()->json(['message' => $success])
            : back()->with('form_success', $success);
    }
}
