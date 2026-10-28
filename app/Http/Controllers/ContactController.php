<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Hiển thị trang liên hệ
    public function index()
    {
        return view('contact');
    }

    // Xử lý gửi form liên hệ
    public function send(Request $request)
    {
        // Kiểm tra dữ liệu người dùng nhập
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'support_type' => 'nullable|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',

            'phone.max' => 'Số điện thoại không hợp lệ.',

            'message.required' => 'Vui lòng nhập nội dung cần hỗ trợ.',
        ]);

        // Sau khi gửi thành công, chuyển sang trang thông báo
        return view('contact-success');
    }
}