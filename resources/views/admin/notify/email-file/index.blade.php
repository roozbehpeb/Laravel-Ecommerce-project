@extends('admin.layouts.master')

@section('head-tag')
    <title>فایل های اطلاعیه ایمیلی </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#"> اطلاعیه ایمیلی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> فایل های اطلاعیه ایمیلی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        فایل اطلاعیه ایمیلی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.notify.email-file.create', $email->id) }}" class="btn btn-info btn-sm">ایجاد
                        فایل اطلاعیه ایمیلی</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان ایمیل</th>
                                <th>نام فایل</th>
                                <th>سایز فایل</th>
                                <th>نوع فایل</th>
                                <th>دسترسی فایل</th>
                                <th>وضعیت</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($email->files as $key => $file)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $email->subject }}</td>
                                    <td>{{ $file->original_name }}</td>
                                    <td>{{ $file->file_size }}</td>
                                    <td>{{ $file->file_type }}</td>
                                    <td>{{ $file->access == 0 ? 'عمومی' : 'خصوصی' }}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="{{ $file->id }}"
                                                onchange="changeStatus({{ $file->id }})"
                                                data-url="{{ route('admin.notify.email-file.status', $file->id) }}"
                                                @if ($file->status === 1) checked @endif>
                                            <label class="custom-control-label" for="{{ $file->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.notify.email-file.edit', $file->id) }}"
                                            class="btn btn-info btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                        <a href="{{ route('admin.notify.email-file.download', $file->id) }}"
                                            class="btn btn-success btn-sm"><i class="fa fa-download"></i> دانلود</a>
                                        <form class="d-inline"
                                            action="{{ route('admin.notify.email-file.destroy', $file->id) }}"
                                            method="post">
                                            @csrf
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger btn-sm delete" type="submit"><i
                                                    class="fa fa-trash-alt"></i> حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </section>

            </section>
        </section>
    </section>
@endsection



@section('script')
    <script type="text/javascript">
        function changeStatus(id) {
            var element = $("#" + id)
            var url = element.attr('data-url')
            var elementValue = !element.prop('checked');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        if (response.checked) {
                            element.prop('checked', true);
                            successToast_Active('دسته بندی با موفقیت فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast_Deactive('دسته بندی با موفقیت غیر فعال شد')
                        }
                    } else {
                        element.prop('checked', elementValue);
                        errorToast('هنگام ویرایش مشکلی بوجود امده است')
                    }
                },
                error: function() {
                    element.prop('checked', elementValue);
                    errorToast('ارتباط برقرار نشد')
                }
            });

            function showToast(message, bgColor) {
                var toastTag =
                    '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex ' + bgColor + ' text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(toastTag);
                $('.toast').toast('show').delay(2000).queue(function() {
                    $(this).remove();
                });
            }

            function successToast_Active(message) {
                showToast(message, 'bg-success');
            }

            function successToast_Deactive(message) {
                showToast(message, 'bg-info');
            }




            function errorToast(message) {

                var errorToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(errorToastTag);
                $('.toast').toast('show').delay(2000).queue(function() {
                    $(this).remove();
                })
            }
        }
    </script>


    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
