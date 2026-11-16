<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập với tư cách Quản trị viên!');
        }

        $user = Auth::user();
        if ((int) $user->role === 1 || $user->role === 'admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang Quản trị (Admin)!');
    }
}
