<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    {{-- <link rel="stylesheet" href="{{ asset('resources/css/grid.css') }}">
<link rel="stylesheet" href="{{ asset('resources/css/style.css') }}"> --}}




    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/grid.css', 'resources/css/style.css'])


</head>

<body dir="rtl">

    <header class="header">

        <section class="sidebar-header bg-gray">
            <section class="d-flex justify-content-between flex-md-row-reverse px-2">
                <span class="d-inline d-md-none"><i class="fas fa-toggle-off"></i></span>
                <span class="d-none d-md-inline"><i class="fas fa-toggle-on"></i></span>
                <span><img class="logo" src="uploads/images/logo.jpg" alt=""></span>
                <span class="d-md-none"><i class="fas fa-ellipsis-h"></i></span>
            </section>
        </section>



        <section class="body-header">
            <section class="d-flex justify-content-between">

                <section>
                    <span class="me-5 ">
                        <span class="search-area d-none">
                            <i class="fas fa-times pointer"></i>
                            <input type="text" class="search-input ">
                            <i class="fas fa-search p-1 d-none d-md-inline pointer"></i>
                        </span>
                        <i class="fas fa-search pointer"></i>
                    </span>

                    <span class=" p-1 d-none d-md-inline me-5">
                        <i class="fas fa-compress d-none pointer"></i>
                        <i class="fas fa-expand pointer "></i>
                    </span>
                </section>

                <section>
                    <span class="ms-2 ml-md-4 position-relative"><i class="far fa-bell"><sup class="badge bg-danger">4</sup></i></span>
                </section>

                <section class="header-notification">
                    <section class="d-flex justify-content-betwee">
                        <span class="px-2">نوتیفیکیشن ها</span>
                        <span  class="px-2">
                            <span class="badge bg-danger">جدید</span>
                        </span>
                    </section>
                </section>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-action">
                        <section class="media">
                            <img src="uploads/images/avaratr.jpg" alt="" width="90px">   
                        </section>
                        <section class="media-body">
                            <h5 class="mt-0">محمدرضا</h5>
                            <p>سلام خوبی؟</p>
                            <p>30دقیقه پیش</p>

                        </section>
                    </li>
                </ul>
            </section>
        </section>
    </header>
</body>

</html>
