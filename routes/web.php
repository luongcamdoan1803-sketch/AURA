<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

/* Trang chủ */
Route::get('/', [HomeController::class, 'index'])->name('home');

/* Sản phẩm */
Route::get('/products', function () {
    return view('home');
})->name('products.index');

Route::get('/products/{id}', function ($id) {
    return view('home');
})->name('products.show');

/* Hiển thị trang đăng nhập */
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

/* Xử lý đăng nhập */
Route::post('/login', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'Vui lòng nhập email.',
        'email.email' => 'Email không đúng định dạng.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
    ]);

    if (Auth::attempt($credentials)) {
        request()->session()->regenerate();

        /* Nếu là ADMIN thì chuyển đến trang Admin */
        if ((int) Auth::user()->role === 1) {
            return redirect()->route('admin.index');
        }

        /* Nếu là khách hàng thì quay lại trang đang xem dở (vd: trang thanh toán), mặc định về trang chủ */
        return redirect()->intended('/');
    }

    return back()
        ->withInput(request()->only('email'))
        ->with('error', 'Email hoặc mật khẩu không chính xác.');
})->name('login.submit');

/* Hiển thị trang đăng ký */
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

/* Xử lý đăng ký */
Route::post('/register', function () {
    $data = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|min:6|confirmed',
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

    /* Tạo tài khoản */
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'] ?? null,
        'password' => Hash::make($data['password']),
        'role' => 0,
    ]);

    /* Đăng nhập ngay sau khi đăng ký */
    Auth::login($user);
    request()->session()->regenerate();

    return redirect('/')
        ->with('status', 'Đăng ký tài khoản thành công!');
})->name('register.submit');

/* Đăng xuất */
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

/* ==================== GIỎ HÀNG - THANH TOÁN - ĐƠN HÀNG (Bảo Trân) ==================== */

/* Giỏ hàng: ai cũng thêm được, các thao tác chạy bằng AJAX */
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them', [CartController::class, 'add'])->name('cart.add');
Route::post('/gio-hang/cap-nhat', [CartController::class, 'update'])->name('cart.update');
Route::post('/gio-hang/xoa', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/gio-hang/ma-giam-gia', [CartController::class, 'applyVoucher'])->name('cart.voucher');
Route::delete('/gio-hang/ma-giam-gia', [CartController::class, 'removeVoucher'])->name('cart.voucher.remove');

/* Thanh toán & đơn hàng - yêu cầu đăng nhập */
Route::middleware('auth')->group(function () {
    Route::get('/thanh-toan', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/thanh-toan', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

/* Giới thiệu & Liên hệ */
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact.index');

Route::post('/contact/send', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable',
        'support_type' => 'nullable',
        'message' => 'required',
    ]);

    return view('contact-success');
})->name('contact.send');

/* Trang Admin */
Route::get('/admin', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (Auth::user()->role !== 'admin') {
        return redirect('/');
    }

    return view('admin.index');
})->name('admin.index');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

/* TÀI KHOẢN KHÁCH HÀNG */
Route::get('/account', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return view('account.index');
})->name('account.index');

Route::get('/account/edit', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return view('account.edit');
})->name('account.edit');

Route::put('/account/update', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    $data = request()->validate([
        'name' => [
            'required',
            'string',
            'max:255'
        ],
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($user->id)
        ],
        'phone' => [
            'nullable',
            'string',
            'max:20'
        ],
    ], [
        'name.required' => 'Vui lòng nhập họ và tên.',
        'email.required' => 'Vui lòng nhập email.',
        'email.email' => 'Email không đúng định dạng.',
        'email.unique' => 'Email này đã được sử dụng.',
        'phone.max' => 'Số điện thoại không hợp lệ.',
    ]);

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->phone = $data['phone'] ?? null;
    $user->save();

    return redirect()
        ->route('account.index')
        ->with('success', 'Thông tin cá nhân đã được cập nhật.');
})->name('account.update');

Route::put('/account/change-password', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $data = request()->validate([
        'current_password' => ['required'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ], [
        'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
        'password.required' => 'Vui lòng nhập mật khẩu mới.',
        'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
        'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
    ]);

    $user = Auth::user();

    if (!Hash::check($data['current_password'], $user->password)) {
        return back()->withErrors([
            'current_password' => 'Mật khẩu hiện tại không chính xác.'
        ]);
    }

    if (Hash::check($data['password'], $user->password)) {
        return back()->withErrors([
            'password' => 'Mật khẩu mới phải khác mật khẩu hiện tại.'
        ]);
    }

    $user->password = Hash::make($data['password']);
    $user->save();

    return redirect()
        ->route('account.index')
        ->with('success', 'Mật khẩu đã được thay đổi thành công.');
})->name('account.password.update');

/* ROUTE CỬA HÀNG VÀ 6 TRANG DANH MỤC HOA */
Route::get('/san-pham', [ProductController::class, 'index'])->name('shop.index');
Route::get('/hoa-tinh-yeu', [ProductController::class, 'hoaTinhYeu'])->name('shop.love');
Route::get('/hoa-sinh-nhat', [ProductController::class, 'hoaSinhNhat'])->name('shop.birthday');
Route::get('/hoa-chuc-mung', [ProductController::class, 'hoaChucMung'])->name('shop.congrats');
Route::get('/hoa-khai-truong', [ProductController::class, 'hoaKhaiTruong'])->name('shop.opening');
Route::get('/hoa-cuoi', [ProductController::class, 'hoaCuoi'])->name('shop.wedding');
Route::get('/hoa-theo-mua', [ProductController::class, 'hoaTheoMua'])->name('shop.season');

/* Chi tiết hoa & API Popup */
Route::get('/san-pham/{id}', [ProductController::class, 'show'])->name('shop.detail');
Route::get('/api/san-pham/{id}', [ProductController::class, 'getProductJson'])->name('shop.api.detail');

/* Đánh giá bình luận AJAX */
Route::post('/danh-gia', [ReviewController::class, 'store'])->name('review.store');
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Str;
//tất cả sp

Route::post('/product/{id}/review', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');
Route::get('/api/product/{id}', [ProductController::class, 'getProductJson']);
Route::get('/tat-ca-san-pham', [ProductController::class, 'allProducts'])->name('products.all');
Route::get('/product-json/{id}', [ProductController::class, 'getProductJson'])->name('product.json');
