@extends('admin.layouts.master')

@section('head-tag')
<title>مشتریان</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> مشتریان</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    مشتریان
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.customer.create') }}" class="btn btn-info btn-sm">ایجاد مشتری جدید</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ایمیل</th>
                            <th>شماره موبایل</th>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>فعال سازی</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)

                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="{{ $user->id }}"
                                        onchange="changeStatus({{ $user->id }})"
                                        data-url="{{ route('admin.user.customer.status', $user->id) }}"
                                        @if ($user->status === 1) checked @endif>
                                    <label class="custom-control-label" for="{{ $user->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="{{ $user->id . 'activation' }}"
                                        onchange="changeActivation({{ $user->id}})"
                                        data-url-activation="{{ route('admin.user.customer.activation', $user->id) }}"
                                        @if ($user->activation === 1) checked @endif>
                                    <label class="custom-control-label" for="{{ $user->id . 'activation' }}"></label>
                                </div>
                            </td>
                            <td class="width-22-rem text-left">
                                <a href="{{ route('admin.user.customer.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                <form class="d-inline" action="{{ route('admin.user.customer.destroy', $user->id) }}" method="post">
                                    @csrf
                                    {{ method_field('delete') }}
                                <button class="btn btn-danger btn-sm delete" type="submit"><i class="fa fa-trash-alt"></i> حذف</button>
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
                            successToast_Active('وضعیت کاربر با موفقیت فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast_Deactive('وضعیت کاربر  غیر فعال شد')
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

        function changeActivation(id) {
            var element = $("#" + id + 'activation')
            var url = element.attr('data-url-activation')
            var elementValue = !element.prop('checked');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        if (response.checked) {
                            element.prop('checked', true);
                            successToast_Active('کاربر با موفقیت فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast_Deactive('کاربر با موفقیت غیر فعال شد')
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
@include('admin.alerts.sweetalert.delete-confirm',['className'=>'delete'])

@endsection
