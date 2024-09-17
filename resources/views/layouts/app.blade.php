<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ระบบตรวจสอบเครื่องจักร</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/logo-laco-1.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">



    {{-- ========================== Bootsrtap CSS ========================== --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">



    {{-- ========================== Data picker ========================== --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300&family=Prompt:wght@300&display=swap');

        body {
            font-family: 'Prompt', sans-serif;
        }

        #btn-back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
        }

        .image-container {
            width: 585px;
            height: 500px;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            border-radius: 8px;

        }

        .wrapper {
            max-width: 2000px;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .wrapper i {
            top: 50%;
            height: 50px;
            width: 50px;
            cursor: pointer;
            font-size: 1.25rem;
            position: absolute;
            text-align: center;
            line-height: 50px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.23);
            transform: translateY(-50%);
            transition: transform 0.1s linear;
        }

        .wrapper i:active {
            transform: translateY(-50%) scale(0.85);
        }

        #left {
            left: -20px;
        }

        .wrapper i:last-child {
            right: -22px;
        }

        .wrapper .carousel {
            display: grid;
            grid-auto-flow: column;
            grid-auto-columns: calc((100% / 3) - 12px);
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 16px;
            border-radius: 8px;
            scroll-behavior: smooth;
            scrollbar-width: none;
        }

        .carousel::-webkit-scrollbar {
            display: none;
        }

        .carousel.no-transition {
            scroll-behavior: auto;
        }

        .carousel.dragging {
            scroll-snap-type: none;
            scroll-behavior: auto;
        }

        .carousel.dragging .card {
            cursor: grab;
            user-select: none;
        }

        .carousel :where(.card, .img) {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .carousel .card {
            scroll-snap-align: start;
            height: 500px;
            list-style: none;
            cursor: pointer;
            flex-direction: column;
            border-radius: 8px;
        }

        .carousel .card h2 {
            font-weight: 500;
            font-size: 1.56rem;
            margin: 30px 0px 0px;
        }

        .carousel .card span {
            color: #6A6D78;
            font-size: 1.31rem;
        }

        .test {
            display: flex;
            max-width: 200px;
            max-height: 200px;
            background-color: red;
        }

        input[type="checkbox"] {
            zoom: 1.5;
        }

        @media screen and (max-width: 900px) {
            .wrapper .carousel {
                grid-auto-columns: calc((100% /2) - 9px);
            }

            .carousel .card {
                scroll-snap-align: start;
                height: 400px;
                list-style: none;
                cursor: pointer;
                flex-direction: column;
                border-radius: 8px;
            }

            /* img {
                max-width: 260px;
                max-height: 415px;
            } */

            .image-container {
                width: 260px;
                height: 415px;
                overflow: hidden;
            }

            .image-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
                border-radius: 8px;

            }

        }

        @media screen and (max-width: 600px) {
            .wrapper .carousel {
                grid-auto-columns: 100%;
            }
        }

        .table-container {
            overflow-x: auto;
        }



        @media screen and (max-width: 767px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .table-responsive>.table {
                margin-bottom: 0;
            }

            .table-responsive>.table>thead>tr>th,
            .table-responsive>.table>tbody>tr>th,
            .table-responsive>.table>tfoot>tr>th,
            .table-responsive>.table>thead>tr>td,
            .table-responsive>.table>tbody>tr>td,
            .table-responsive>.table>tfoot>tr>td {
                white-space: nowrap;
            }
        }

        ::-webkit-scrollbar {
            width: 10px;
            /* กำหนดความกว้างของ scrollbar */
        }

        /* ปรับแต่ง track ของ scrollbar */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* สีพื้นหลังของ track */
        }

        /* ปรับแต่ง thumb (ตัวเลื่อน) ของ scrollbar */
        ::-webkit-scrollbar-thumb {
            background: #368b2a;
            /* สีของ thumb */
            border-radius: 5px;
            /* ทำให้มีขอบโค้ง */
        }

        /* ปรับแต่ง thumb เมื่อ hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #265f1f;
            /* สีของ thumb เมื่อ hover */
        }
    </style>
    @stack('styles')
    @stack('script')
</head>

<body>

    <div id="app">

        <nav class="navbar navbar-expand-lg bg-light d-print-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">ระบบตรวจสอบเครื่องจักร</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @guest
                    @else
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ url('/') }}">หน้าแรก</a>
                            </li>

                            @if (Auth::user()->is_admin == '1')
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('admin') }}">Admin </a>
                                </li>
                            @endif
                        @endguest
                    </ul>
                    <a class="nav-link">
                        @guest
                        @else
                            {{ Auth::user()->name }}

                            <a href="{{ route('logout') }}" class="btn btn-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('ออกจากระบบ') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </a>
                </div>
            </div>
        </nav>
        <button type="button" class="btn btn-primary btn-floating z-3 d-print-none" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>

        <main class="py-4">
            <div class="mx-2">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-warning">
                        <p>{{ $message }}</p>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>

    </div>

    <script>
        $("input:checkbox").on('click', function() {

            var $box = $(this);
            if ($box.is(":checked")) {

                var group = "input:checkbox[id='" + $box.attr("id") + "']";

                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>

    {{-- back-to-top --}}

    <script>
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
    <script>
        function loadFile(event, value) {
            var id = $(value).attr('data-id');
            console.log(id);

            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById(id);
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
</body>


</html>
