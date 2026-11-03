<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function postContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|min:5|max:2000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Cảm ơn bạn đã liên hệ với ChronoLux! Chuyên viên tư vấn của chúng tôi sẽ gọi lại cho bạn trong vòng 15 phút.');
    }

    public function warranty()
    {
        return view('pages.warranty');
    }
}
