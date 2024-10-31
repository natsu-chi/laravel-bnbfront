<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Pier | Login</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .bg-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .bg-cover {
                height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <header class="py-3">
            <div class="d-flex justify-content-between align-items-center">
                <a href="/" id="Link">
                    <img src="/images/public/logo.png" alt="logo" style="max-width: 200px;">
                </a>
                <a href="/">
                    <svg
                        preserveAspectRatio="none"
                        id="Vector_0"
                        class="pointer-events-none"
                        width="14"
                        height="14"
                        viewBox="0 0 14 14"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1 13L13 1M1 1L13 13"
                            stroke="#1B272C"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </a>
            </div>
        </header>
        <div class="row position-relative h-100">
            <!-- Image column (hidden on smaller screens) -->
            <div class="col-lg-6 d-none d-lg-block" style="max-height: 80vh;">
                <img
                    class="bg-cover"
                    src="/images/home/login_01.jpg"
                    alt="main-image"
                    fetchpriority="high" />
            </div>
            <!-- Form column -->
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="d-flex flex-column space-y-2 mb-5 pt-4 px-3 px-md-5">
                    <span class="fw-bold text-neutral-900 text-3xl">登入</span>
                    <span class="text-sm text-neutral-900">登入您的帳號</span>
                </div>
                <form id="loginForm" method="POST" action="/login" class="px-3 px-md-5" onsubmit="return doCheck()">
                    {{ csrf_field() }}
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control form-input" id="fi-username" name="username" placeholder="example_username" value="{{ old('username') }}">
                        <label for="fi-username">帳號</label>
                        <div class="valid-feedback"></div>
                        <div id="msg-username" class="invalid-feedback">
                            請輸入帳號
                        </div>
                    </div>

                    <div class="mb-3 form-floating">
                        <input type="password" class="form-control" id="fi-pwd" name="pwd" placeholder="Password">
                        <label for="fi-pwd">密碼</label>
                        <div class="valid-feedback"></div>
                        <div id="msg-pwd" class="invalid-feedback">
                            請輸入密碼
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" id="fi-code" name="code" placeholder="請輸入驗證碼">
                        </div>
                        <div class="col">
                            <img src="{{ captcha_src() }}" alt="captcha" class="float-end" onclick="this.src='/captcha/default?' + Math.random()" style="cursor: pointer">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <input type="checkbox" id="remember_me" />
                            <label for="remember_me" class="text-sm">記住我</label>
                        </div>
                        <div>
                            <a href="#" class="text-muted">
                                <span class="text-sm">忘記密碼 ?</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <span class="text-sm text-danger">
                            @if ($errors->has("error"))
                            {{ $errors->first("error") }}
                            @endif
                        </span>
                        <span class="text-sm text-danger">
                            @if ($errors->has("code"))
                            {{ $errors->first("code") }}
                            @endif
                        </span>
                    </div>

                    <button id="btn-submit" class="btn btn-danger w-100" type="submit">登入</button>
                </form>

                <!-- Footer (Responsive positioning for mobile) -->
                <div class="text-center text-muted py-4 mt-4">
                    <span>© Copyright 2024 - The Pier</span>
                    <span>·</span>
                    <a href="#">
                        <span>使用條款</span>
                    </a>
                    <span>·</span>
                    <a href="#">
                        <span>隱私權政策</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script>
        var flag_username = false;
        var flag_pwd = false;
        var flag_code = false;

        $(document).ready(function() {
            doCheck();

            $("#fi-username, #fi-pwd, #fi-code").on("input", function() {
                if ($(this).val().length > 0) {
                    $(this).removeClass("is-invalid").addClass("is-valid");
                } else {
                    $(this).removeClass("is-valid").addClass("is-invalid");
                }
                doCheck();
            });

            function doCheck() {
                flag_username = $("#fi-username").val().length > 0;
                flag_pwd = $("#fi-pwd").val().length > 0;
                flag_code = $("#fi-code").val().length > 0;

                $('#btn-submit').attr('disabled', !(flag_username && flag_pwd && flag_code));
            }
        });
    </script>

</body>
</html>