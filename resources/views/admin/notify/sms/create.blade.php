@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد اطلاعیه پیامکی</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">اطلاعیه پیامکی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد اطلاعیه پیامکی</li>
        </ol>
    </nav>


    <section class="row">

        <section class="col-12 d-flex d-inline">
            <section class="col-8">
                <section class="main-body-container">
                    <section class="main-body-container-header">
                        <h5>
                            ایجاد اطلاعیه پیامکی
                        </h5>
                    </section>

                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        <a href="{{ route('admin.notify.sms.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                    </section>

                    <section>
                        <form action="{{ route('admin.notify.sms.store') }}" method="post">
                            @csrf
                            <section class="row">

                                <section class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="">عنوان پیامک</label>
                                        <input type="text" name="title" class="form-control form-control-sm"
                                            value="{{ old('title') }}">
                                    </div>
                                    @error('title')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </section>


                                <section class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="">تاریخ انتشار</label>
                                        <input type="text" name="published_at" id="published_at"
                                            class="form-control form-control-sm d-none">
                                        <input type="text" id="published_at_view" class="form-control form-control-sm">
                                    </div>
                                    @error('published_at')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </section>

                                <section class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="status">وضعیت</label>
                                        <select name="status" id="" class="form-control form-control-sm"
                                            id="status">
                                            <option value="0" @if (old('status') == 0) selected @endif>غیرفعال
                                            </option>
                                            <option value="1" @if (old('status') == 1) selected @endif>فعال
                                            </option>
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
                                    <div class="form-group">
                                        <label for="">متن پیامک</label>
                                        <textarea name="body" id="body" class="form-control form-control-sm" rows="6">{{ old('body') }}</textarea>
                                    </div>
                                    @error('body')
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
                        </form>
                    </section>

                </section>
                <section class="col-4">
                    <img src="{{ asset('admin-assets/images/avatar-2.jpg') }}" alt="sms" class="img-fluid">
                </section>
            </section>
        </section>
    @endsection


    @section('script')
        <script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
        <script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#published_at_view').persianDatepicker({
                    format: 'YYYY/MM/DD',
                    altField: '#published_at',
                    timePicker: {
                        enabled: true,
                        meridiem: {
                            enabled: true
                        }
                    }
                })
            });
        </script>
    @endsection
