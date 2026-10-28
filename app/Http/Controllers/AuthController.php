<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }


    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Kiểm tra dữ liệu nhập vào
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);


        // Kiểm tra tài khoản
        if (Auth::attempt($credentials)) {

            // Tạo lại session sau khi đăng nhập
            $request->session()->regenerate();


            // Nếu là Admin
            if (Auth::user()->role === 'admin') {
                return redirect()
                    ->route('admin.index');
            }


            // Nếu là khách hàng
            return redirect()
                ->route('home')
                ->with('status', 'Đăng nhập thành công!');
        }


        // Sai email hoặc mật khẩu
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email hoặc mật khẩu không chính xác.');
    }


    // Hiển thị trang đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }


    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Kiểm tra dữ liệu
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được đăng ký.',

            'phone.max' => 'Số điện thoại không được quá 20 ký tự.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);


        // Tạo tài khoản khách hàng
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 0,
        ]);


        // Đăng nhập ngay sau khi đăng ký
        Auth::login($user);

        $request->session()->regenerate();


        // Quay về trang chủ
        return redirect()
            ->route('home')
            ->with('status', 'Đăng ký tài khoản thành công!');
    }


    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        // Xóa session cũ
        $request->session()->invalidate();

        // Tạo CSRF token mới
        $request->session()->regenerateToken();


        return redirect()
            ->route('home');
    }
}