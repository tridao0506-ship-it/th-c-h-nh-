<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmailCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        return redirect()->route('home', ['show_login' => 1]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'login_type' => 'nullable|in:customer,admin',
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($request->input('login_type') === 'admin' && !$user->isAdmin()) {
                Auth::logout();
                return redirect()->route('home', ['show_login' => 1, 'tab' => 'admin'])
                    ->with('error', 'Tài khoản của bạn không có quyền Quản trị viên!');
            }

            if ($user->isAdmin()) {
                return redirect()->to(url('/#admin-section'))
                    ->with('success', 'Đăng nhập thành công! Chào mừng Quản trị viên: ' . $user->name);
            }

            // Kiểm tra xác thực email theo chuẩn Lab 3
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')
                    ->with('info', 'Tài khoản của bạn chưa xác thực email. Vui lòng xác thực email để kích hoạt tài khoản!');
            }

            return redirect()->to(url('/#home-section'))
                ->with('success', 'Chào mừng quý khách ' . $user->name . ' đã đăng nhập thành công!');
        }

        return redirect()->route('home', [
            'show_login' => 1,
            'tab' => $request->input('login_type') === 'admin' ? 'admin' : 'login'
        ])->with('error', 'Email hoặc mật khẩu không chính xác. Vui lòng kiểm tra lại!');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:3|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên!',
            'email.required' => 'Vui lòng nhập địa chỉ email!',
            'email.unique' => 'Email này đã được sử dụng!',
            'phone.required' => 'Vui lòng nhập số điện thoại!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'password.min' => 'Mật khẩu phải có ít nhất 3 ký tự!',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp!',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'email_verified_at' => null,
        ]);

        // Gửi email xác thực theo chuẩn Lab 3
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Lỗi gửi email xác thực: ' . $e->getMessage());
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('verification.notice')
            ->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản của bạn.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', 'Bạn đã đăng xuất tài khoản thành công.');
    }
}
