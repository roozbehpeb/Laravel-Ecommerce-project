@extends('admin.layouts.master')

@section('head-tag')
<title>پست ها</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش محتوی</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page">پست ها</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                 پست ها
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.content.post.create') }}" class="btn btn-info btn-sm">ایجاد پست </a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان پست</th>
                            <th>دسته</th>
                            <th>تصویر</th>
                            <th>وضعیت</th>
                            <th>امکان درج کامنت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $key => $post)

                        <tr>
                            <th>{{ $key += 1 }}</th>
                            <td>{{ $post->title }}</td>
                            {{-- <td>{{ $post->postCategory->name }}</td> --}}
                            <td>{{ $post->postCategory ? $post->postCategory->name : 'No Category' }}</td>
                            <td>
                                <img src="{{ asset($post->image['indexArray'][$post->image['currentImage']] ) }}" alt="" width="100" height="50">
                            </td>
                            <td>

                                <label for="{{ $post->id }}"> <input id="{{ $post->id }}"
                                        onchange="changeStatus({{ $post->id }})"
                                        data-url="{{ route('admin.content.post.status', $post->id) }}"
                                        type="checkbox" @if ($post->status === 1) checked @endif>
                                </label>
                            </td>

                            <td>

                                <label for="{{ $post->id }}"> <input id="{{ $post->id }}-commentable"
                                        onchange="commentable({{ $post->id }})"
                                        data-url="{{ route('admin.content.post.commentable', $post->id) }}"
                                        type="checkbox" @if ($post->commentable === 1) checked @endif>
                                </label>
                            </td>

                            <td class="width-16-rem text-left">
                                <a href="{{ route('admin.content.post.edit',$post->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                <form action="{{ route('admin.content.post.destroy', $post->id) }}"
                                    method="POST" class="d-inline ">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger delete btn-sm" type="submit">
                                        <i class="fa fa-trash-alt"></i>
                                        حذف
                                    </button>
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
                            successToast_Active('پست با موفقیت فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast_Deactive('پست با موفقیت غیر فعال شد')
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


<script type="text/javascript">
    function commentable(id) {
        var element = $("#" + id + '-commentable')
        var url = element.attr('data-url')
        var elementValue = !element.prop('checked');

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                if (response.commentable) {
                    if (response.checked) {
                        element.prop('checked', true);
                        successToast_Active('امکان درج کامنت با موفقیت فعال شد')
                    } else {
                        element.prop('checked', false);
                        successToast_Deactive('امکان درج کامنت با موفقیت غیر فعال شد')
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
