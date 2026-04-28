<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function about(): Response
    {
        return Inertia::render('About');
    }

    public function contact(): Response
    {
        return Inertia::render('Contact');
    }

    public function contactSubmit(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        try {
            Mail::raw(
                "Имя: {$data['name']}\nEmail: {$data['email']}\nТема: {$data['subject']}\n\n{$data['message']}",
                function ($m) use ($data) {
                    $m->to(config('mail.from.address'))
                      ->subject('[Billaro Store] '.$data['subject'])
                      ->replyTo($data['email'], $data['name']);
                }
            );
        } catch (\Throwable $e) {
            // Сообщение не отправлено, но не ломаем UX
        }

        return back()->with('success', 'Сообщение отправлено. Мы свяжемся с вами скоро.');
    }
}
