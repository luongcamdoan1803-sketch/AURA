<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Danh sách tài khoản khách hàng và nhân viên quản trị (Eloquent ORM)
     */
    public function index(Request $request)
    {
        $query = User::withCount('orders');

        // Tìm kiếm theo tên, email hoặc số điện thoại
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('email', 'LIKE', "%{$keyword}%")
                  ->orWhere('phone', 'LIKE', "%{$keyword}%");
            });
        }

        // Lọc theo vai trò (0: Khách hàng, 1: Admin)
        if ($request->filled('role')) {
            if ($request->role === 'admin') {
                $query->where(function ($q) {
                    $q->where('role', 1)->orWhere('role', 'admin');
                });
            } elseif ($request->role === 'customer') {
                $query->where(function ($q) {
                    $q->where('role', 0)->orWhere('role', 'customer');
                });
            }
        }

        $users = $query->latest('id')->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Thay đổi nhanh vai trò (Admin / Khách hàng)
     */
    public function toggleRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Bạn không thể tự thay đổi vai trò tài khoản của chính mình!');
        }

        $isAdmin = (int) $user->role === 1 || $user->role === 'admin';
        $user->role = $isAdmin ? 0 : 1;
        $user->save();

        $roleName = $user->role == 1 ? 'Quản trị viên (Admin)' : 'Khách hàng';

        return redirect()->back()
            ->with('success', "Đã chuyển vai trò tài khoản '{$user->name}' thành {$roleName}!");
    }

    /**
     * Xóa tài khoản người dùng
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Bạn không thể xóa tài khoản của chính mình khi đang đăng nhập!');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->back()
            ->with('success', "Đã xóa tài khoản '{$userName}' khỏi hệ thống!");
    }
}
