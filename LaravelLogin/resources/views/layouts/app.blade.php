<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icon & Tilttle -->
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/gif" height="16" width="16">
    <title>{{ __('Group Round') }}</title>
    
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('style/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('style/css/customForAll.css')}}">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{URL::asset('js/bootstrap.bundle.js')}}"></script>
    <script src="{{URL::asset('js/jquery-3.6.0.min.js')}}"></script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript" language="javascript">google.load("jquery", "1.3.2");</script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

</head>

<body style="background-color:  #f6f7f8;">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded">
            <div class="container-fluid">
                {{-- home --}}
                <button type="button" class="btn">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('img/logo-text-1.png') }}" type="image/gif" width="120px">
                    </a>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- 活動建立頁面 -->
                        <li class="nav-item">
                            <button type="button" class="btn btn-orange btn-sm"><a href="#" {{--活動route--}}
                                    class="link-light">辦活動</a></button>
                        </li>
                    </ul>

                    <form class="d-flex">
                        <!-- 搜尋 -->
                        <input class="form-control me-2 bg-light" type="search" placeholder="搜尋..." aria-label="Search">
                        <a href="{{--搜尋route--}}"><button class="btn btn-secondary btn-sm" type="submit">
                            <img src="{{ asset('img/search.svg') }}" type="image/gif" size="16x16"></button>
                        </a>
                    </ul>
                    </form>
                    
                    <!-- Authentication Links -->
                    <div class="nav-link link-dark">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('login') }}">
                                        <img src="{{ asset('img/log-in.svg') }}" type="image/gif" size="16x16">{{ __('登入/註冊') }}
                                    </a>
                                </li>
                            @endif

                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                            
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('登出') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </div>
                </div>
            </div>
            </div>
        </nav>

        <main class="py-4 mb-5">
            @yield('content')
        </main>

        <!-- 頁尾 -->
        <footer class="bg-dark text-center text-lg-start navbar-fixed-bottom">
            <div class="container p-4">
                <div class="row">
                    <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase text-light fw-bold">關於我們</h5>
                        <p class="text-light">
                            團團團<br>
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase text-light fw-bold">聯絡我們</h5>
                        <p class="text-light">
                            電話<br>
                            信箱<br>
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                        <!-- Icon links -->
                        <div class="container pt-4 text-center text-white">
                            <!-- Section: Social media -->
                            <section class="mb-2">
                                <!-- Facebook -->
                                <a
                                    class="btn btn-link btn-floating btn-lg text-dark m-1"
                                    href="#!"
                                    role="button"
                                    data-mdb-ripple-color="dark"
                                    ><img src="{{ asset('img/icons8-facebook-24.png') }}" type="img/gif" alt="facebook" size="24x24">
                                </a>
                                <!-- Twitter -->
                                <a
                                    class="btn btn-link btn-floating btn-lg text-dark m-1"
                                    href="#!"
                                    role="button"
                                    data-mdb-ripple-color="dark"
                                    ><img src="{{ asset('img/icons8-twitter-26.png') }}" alt="twitter" size="24x24">
                                </a>
                                <!-- Instagram -->
                                <a
                                    class="btn btn-link btn-floating btn-lg text-dark m-1"
                                    href="#!"
                                    role="button"
                                    data-mdb-ripple-color="dark"
                                    ><img src="{{ asset('img/icons8-instagram-24.png') }}" alt="instagram" size="24x24">
                                </a>
                                <!-- Github -->
                                <a
                                    class="btn btn-link btn-floating btn-lg text-dark m-1"
                                    href="#!"
                                    role="button"
                                    data-mdb-ripple-color="dark"
                                    ><img src="{{ asset('img/icons8-github-24.png') }}" alt="github" size="24x24">
                                </a>
                                <!-- mail -->
                                <a
                                    class="btn btn-link btn-floating btn-lg text-dark m-1"
                                    href="#!"
                                    role="button"
                                    data-mdb-ripple-color="dark"
                                    ><img src="{{ asset('img/icons8-mail-24.png') }}" alt="mailUs" size="24x24">
                                </a>
                            </section>
                            <!-- Copyright -->
                            <div class="text-center p-3 text-light">
                                <h6>© 2021 GroupRound團團轉共遊平台製作小組</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
