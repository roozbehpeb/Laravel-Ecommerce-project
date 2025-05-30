@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش پست</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">پست</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش پست</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش پست
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.content.post.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.content.post.update', $post->id) }}" method="POST"
                        enctype="multipart/form-data" id="form">
                        @csrf
                        {{ method_field('put') }}
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">عنوان پست</label>
                                    <input type="text" class="form-control form-control-sm" name="title"
                                        value="{{ old('title', $post->title) }}">>
                                </div>
                                @error('title')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">انتخاب دسته</label>
                                    <select name="category_id" id="" class="form-control form-control-sm">
                                        <option value="">دسته را انتخاب کنید</option>
                                        @foreach ($postCategories as $postCategory)
                                            <option value="{{ $postCategory->id }}"
                                                @if (old('category_id', $post->category_id) == $postCategory->id) selected @endif>{{ $postCategory->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('category_id')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-3 ">
                                <div class="form-group">
                                    <label for="image">تصویر</label>
                                    <input type="file" class="form-control form-control-sm" name="image"
                                        id="image">
                                    <img src="{{ asset($post->image['indexArray'][$post->image['currentImage']]) }}"
                                        alt="" width="100" height="50" class="mt-3">

                                </div>
                                <span class="float-end p-1">
                                    @error('image')
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
                                        <option value="1" @if (old('status', $post->status) == 1) selected @endif>فعال
                                        </option>
                                        <option value="0" @if (old('status', $post->status) == 0) selected @endif>غیر فعال
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


                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="commentable">امکان درج کامنت</label>
                                    <select name="commentable" id="commentable" class="form-control form-control-sm">
                                        <option value="1" @if (old('commentable', $post->commentable) == 1) selected @endif>فعال
                                        </option>
                                        <option value="0" @if (old('commentable', $post->commentable) == 0) selected @endif>غیر فعال
                                        </option>
                                    </select>

                                </div>
                                <span class=" p-1">
                                    @error('commentable')
                                        <span class="alert_required bg-danger text-white  rounded " role="alert">

                                            {{ $message }}

                                        </span>
                                    @enderror
                                </span>
                            </section>


                            <section class="row flex-row-reverse justify-content-end">

                                <section class="col-12 col-md-6 my-2 d-flex">
                                    <label for="commentable">سایز تصویر:</label>
                                    @php
                                        $number = 1;
                                        @endphp
                                    @foreach ($post->image['indexArray'] as $key => $value )
                                    <section class="col-md-{{ 6 / $number }} ">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="currentImage" value="{{ $key }}" id="{{ $number }}" @if($post->image['currentImage'] == $key) checked @endif>
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
                            </section>


                            <section class="col-12 col-md-6">
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

                            <section class="col-12 col-md-3">
                                <label for="tags">تگ ها</label>
                                <input type="hidden" class="form-control form-control-sm" name="tags" id="tags"
                                    value="{{ old('tags',$post->tags) }}">

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

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">خلاصه پست</label>
                                    <textarea name="summary" id="summary" class="form-control form-control-sm" rows="6">{{ old('summary', $post->summary) }}</textarea>
                                </div>
                                @error('summary')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">متن پست</label>
                                    <textarea name="body" id="body" class="form-control form-control-sm" rows="6">{{ old('body', $post->body) }}</textarea>
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
        </section>
    </section>
@endsection

@section('script')
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    <script>
        CKEDITOR.replace('body');
        CKEDITOR.replace('summary');
    </script>
    <script>
        $(document).ready(function() {
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#published_at'
            })
        });
    </script>

    <script>
        $(document).ready(function() {
            var tags_input = $('#tags');
            var select_tags = $('#select_tags');
            var default_tags = tags_input.val();
            var default_data = null;

            if (tags_input.val() !== null && tags_input.val().length > 0) {
                default_data = default_tags.split(',');
            }

            select_tags.select2({
                placeholder: 'لطفا تگ های خود را وارد نمایید',
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
