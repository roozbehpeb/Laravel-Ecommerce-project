@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد کاربر مشتری</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">مشتریان</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد کاربر مشتری</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                  ایجاد کاربر مشتری
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.customer.index') }}" class="btn btn-info btn-sm">بازگشت</a>
            </section>

            <section>
                <form action="{{ route('admin.user.customer.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <section class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">نام</label>
                                <input type="text" name="first_name" class="form-control form-control-sm" value="{{ old('first_name') }}">
                            </div>
                            @error('first_name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">نام خانوادگی</label>
                                <input type="text" name="last_name" class="form-control form-control-sm" value="{{ old('last_name') }}">
                            </div>
                            @error('last_name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">ایمیل</label>
                                <input type="text" name="email" class="form-control form-control-sm" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>
                     <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for=""> شماره موبایل</label>
                                <input type="text" name="mobile" class="form-control form-control-sm" value="{{ old('mobile') }}">
                            </div>
                            @error('mobile')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>
                     <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">کلمه عبور</label>
                                <input type="password" name="password" class="form-control form-control-sm">
                            </div>
                            @error('password')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>
                    <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">تکرار کلمه عبور</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-sm">
                            </div>
                            @error('password_confirmation')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>
                    <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">تصویر</label>
                                <input type="file" name="profile_photo_path" class="form-control form-control-sm">
                            </div>
                            @error('profile_photo_path')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>

                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select name="status" id="" class="form-control form-control-sm" id="status">
                                    <option value="0" @if(old('status') == 0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                </select>
                            </div>
                            @error('status')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>
                        <section class="col-12">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </section>
        </section>
    </section>
</section>

@endsection
