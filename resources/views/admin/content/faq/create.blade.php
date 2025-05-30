@extends('admin.layouts.master')

@section('head-tag')
<title>سوالات متداول</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">سوالات متداول</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد سوال</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                  ایجاد سوال
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.content.faq.index') }}" class="btn btn-info btn-sm">بازگشت</a>
            </section>

            <section>
                <form action="{{ route('admin.content.faq.store') }}" method="post" id="form">
                    @csrf
                    <section class="row">

                        <section class="col-12">
                            <div class="form-group">
                                <label for="">پرسش</label>
                                <input  value="{{ old('question') }}" name="question" id="question" type="text" class="form-control form-control-sm" rows="6">
                            </div>
                        </section>

                        <span class=" p-1">
                            @error('question')
                                <span class="alert_required bg-danger text-white  rounded " role="alert">

                                    {{ $message }}

                                </span>
                            @enderror
                        </span>



                        <section class="col-12 col-md-3 my-2">
                            <label for="tags">تگ ها</label>
                            <input type="hidden" class="form-control form-control-sm" name="tags" id="tags"
                                value="{{ old('tags') }}">

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
                                    <option value="1" @if (old('status') == 1) selected @endif>فعال
                                    </option>
                                    <option value="0" @if (old('status') == 0) selected @endif>غیر فعال
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

                        <section class="col-12">
                            <div class="form-group">
                                <label for="">پاسخ</label>
                                <textarea name="answer" id="answer" class="form-control form-control-sm" rows="6">{{ old('answer') }}</textarea>
                            </div>
                        </section>

                        <span class=" p-1">
                            @error('answer')
                                <span class="a lert_required bg-danger text-white  rounded " role="alert">

                                    {{ $message }}

                                </span>
                            @enderror
                        </span>


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
    <script>
        CKEDITOR.replace('answer');
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