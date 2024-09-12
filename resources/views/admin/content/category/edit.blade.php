@extends('admin.layouts.master')

@section('head-tag')
    <title>دسته بندی</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">دسته بندی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد دسته بندی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد دسته بندی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.content.category.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.content.category.update', $PostCategory->id) }}" method="POST"
                        enctype="multipart/form-data" id="form">
                        @csrf
                        {{ method_field('put') }}
                        <section class="row">
                            <section class="col-12 col-md-3 my-1">
                                <div class="form-group">
                                    <label for="name">نام دسته</label>
                                    <input type="text" class="form-control form-control-sm" name="name" id="name"
                                        value="{{ old('name', $PostCategory->name) }}">
                                </div>
                                <span class=" p-1">
                                    @error('name')
                                        <span class="alert_required bg-danger text-white  rounded " role="alert">

                                            {{ $message }}

                                        </span>
                                    @enderror
                                </span>

                            </section>


                            <section class="col-12 col-md-3 my-2">
                                <label for="tags">تگ ها</label>
                                <input type="hidden" class="form-control form-control-sm" name="tags" id="tags"
                                    value="{{ old('tags',$PostCategory->tags) }}">

                                <select id="select_tags" class="slect2 form-control form-control-sm " multiple>
                                </select>
                                </div>
                                <span class=" p-1">
                                    @error('tags')
                                        <span class="alert_required bg-danger text-white  rounded " role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </span>
                            </section>

                            <section class="col-12 col-md-3 my-2">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select name="status" id="stasus" class="form-control form-control-sm">
                                        <option value="1" @if (old('status', $PostCategory->status) == 1) selected @endif>فعال
                                        </option>
                                        <option value="0" @if (old('status', $PostCategory->status) == 0) selected @endif>غیر فعال
                                        </option>
                                    </select>

                                </div>
                                <span class=" p-1">
                                    @error('status')
                                        <span class="alert_required bg-danger text-white  rounded " role="alert">

                                            {{ $message }}

                                        </span>
                                    @enderror
                                </span>
                            </section>
                            <section class="col-12 col-md-3 my-2">
                                <div class="form-group">
                                    <label for="image">تصویر</label>
                                    <input type="file" class="form-control form-control-sm" name="image"
                                        id="image">
                                </div>
                                <span class="float-end p-1">
                                    @error('image')
                                        <span class="alert_required bg-danger text-white  rounded " role="alert">

                                            {{ $message }}

                                        </span>
                                    @enderror
                                </span>
                            </section>

                            <section class="row flex-row-reverse ">
                                <section class="col-12 col-md-6 my-2 d-flex">
                                    @php
                                        $number = 1;
                                        @endphp
                                    @foreach ($PostCategory->image['indexArray'] as $key => $value )
                                    <section class="col-md-{{ 6 / $number }} ">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="currentImage" value="{{ $key }}" id="{{ $number }}" @if($PostCategory->image['currentImage'] == $key) checked @endif>
                                            <label for="{{ $number }}" class="form-check-label mx-2">
                                                <img src="{{ asset($value) }}" class="w-100" alt="">
                                            </label>
                                        </div>
                                    </section>
                                    @php
                                    $number++;
                                @endphp
                                    @endforeach
                                </section>
                                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="">توضیحات</label>
                                        <textarea name="description" id="description" class="form-control form-control-sm" rows="6">{{ old('description', $PostCategory->description) }}</textarea>
                                        <span class=" p-1 my-2">
                                            @error('description')
                                                <span class="alert_required bg-danger text-white  rounded " role="alert">

                                                    {{ $message }}

                                                </span>
                                            @enderror
                                        </span>
                                    </div>
                                    </sectio <section class="col-12">
                                    <button class="btn btn-primary button-primary btn-lg  p-2">ثبت</button>
                                </section>
                            </section>
                        </form>
                    </section>

                            </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>

<script>
    $(document).ready(function () {
        var tags_input = $('#tags');
        var select_tags = $('#select_tags');
        var default_tags = tags_input.val();
        var default_data = null;

        if(tags_input.val() !== null && tags_input.val().length > 0)
        {
            default_data = default_tags.split(',');
        }

        select_tags.select2({
            placeholder : 'لطفا تگ های خود را وارد نمایید',
            tags: true,
            data: default_data
        });
        select_tags.children('option').attr('selected', true).trigger('change');


        $('#form').submit(function ( event ){
            if(select_tags.val() !== null && select_tags.val().length > 0){
                var selectedSource = select_tags.val().join(',');
                tags_input.val(selectedSource)
            }
        })
    })
</script>
@endsection
