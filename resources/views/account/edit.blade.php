@extends('layouts.account')

@section('title', 'Chỉnh sửa thông tin — AURA FLORIST')

@section('content')

<div class="account-page">
    <div class="container">

        <!-- TIÊU ĐỀ -->
        <div class="account-heading">
            <p class="account-label">
                AURA FLORIST
            </p>

            <h1>CHỈNH SỬA THÔNG TIN</h1>

            <div class="account-decoration">
                <span></span>
                <i class="bi bi-pencil-square"></i>
                <span></span>
            </div>

            <p class="account-description">
                Cập nhật thông tin cá nhân của bạn.
            </p>
        </div>

        <!-- FORM -->
        <div class="account-form-card">
            <form action="{{ route('account.update') }}"
                  method="POST">

                @csrf
                @method('PUT')

                <!-- HỌ VÀ TÊN -->
                <div class="account-form-group">
                    <label for="name">
                        Họ và tên
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', Auth::user()->name) }}"
                           placeholder="Nhập họ và tên">

                    @error('name')
                        <div class="account-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- EMAIL -->
                <div class="account-form-group">
                    <label for="email">
                        Email
                    </label>

                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', Auth::user()->email) }}"
                           placeholder="Nhập email">

                    @error('email')
                        <div class="account-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- SỐ ĐIỆN THOẠI -->
                <div class="account-form-group">
                    <label for="phone">
                        Số điện thoại
                    </label>

                    <input type="text"
                           id="phone"
                           name="phone"
                           value="{{ old('phone', Auth::user()->phone) }}"
                           placeholder="Nhập số điện thoại">

                    @error('phone')
                        <div class="account-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="account-form-actions">
                    <a href="{{ route('account.index') }}"
                       class="account-back-btn">
                        <i class="bi bi-arrow-left"></i>
                        Quay lại
                    </a>

                    <button type="submit"
                            class="account-save-btn">
                        <i class="bi bi-check-lg"></i>
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection