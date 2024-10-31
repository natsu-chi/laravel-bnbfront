<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Pier | Sign up</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <!-- toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>
    @if(Session::has("message"))
    <script>
        Toastify({
            text: "{{ Session::get('message') }}",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "left",
            stopOnFocus: false,
        }).showToast();
    </script>
    @endif
    
    <div class="container">
        <header class="my-4">
            <div class="d-flex justify-content-between align-items-center">
                <a href="/" id="Link">
                    <img src="/images/public/logo.png" alt="logo" class="img-fluid" style="max-width: 200px;">
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
            <!-- 圖片區塊: 僅在大於md裝置顯示 -->
            <div class="col-md-6 d-none d-md-block">
                <img
                    class="img-fluid bg-cover"
                    src="https://robbyn-sxuwti7d6j.figweb.site/cdn-cgi/imagedelivery/s-dfVpmPR-aKHmwFNwAgnQ/robbyn-sxuwti7d6j.figweb.site-c0fb41030e40d0565730174362a3f8d11f078f0b/public"
                    alt="main-image"
                    fetchpriority="high"
                    style="max-height: 80vh;" />
            </div>

            <!-- 表單區塊 -->
            <div class="col-md-6 col-12">
                <div class="d-flex flex-column space-y-2 mb-8">
                    <span class="fw-bold text-neutral-900 display-6">註冊</span>
                    <span class="text-muted">註冊您的帳號</span>
                </div>

                <form method="POST" action="/signup" id="f-signup">
                    {{ csrf_field() }}
                    <div class="mb-3 form-floating">
                        <input type="email" class="form-control" id="fi-email" name="email" placeholder="name@example.com">
                        <label for="fi-email">Email</label>
                        <div class="valid-feedback">格式正確</div>
                        <div id="msg-email" class="invalid-feedback" data-msg01="email 格式錯誤 (長度需大於 2 字, 並包含 @)" data-msg02="email 已被註冊">請輸入 email</div>
                    </div>

                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" id="fi-username" name="username" placeholder="username">
                        <label for="fi-username">帳號</label>
                        <div id="msg-username" class="invalid-feedback" data-msg01="帳號格式錯誤 (長度需介於 3-10 字)">請輸入帳號</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col form-floating">
                            <input type="password" class="form-control" id="fi-pwd" name="pwd" placeholder="Password">
                            <label for="fi-pwd">密碼</label>
                            <div id="msg-pwd" class="invalid-feedback" data-msg01="密碼格式錯誤 (長度需介於 3-12 字)">請輸入密碼</div>
                        </div>

                        <div class="col form-floating">
                            <input type="password" class="form-control" id="fi-pwd-chk" placeholder="Password">
                            <label for="fi-pwd-chk">確認密碼</label>
                            <div class="valid-feedback">密碼一致</div>
                            <div id="msg-pwd-chk" class="invalid-feedback">密碼不一致</div>
                        </div>
                    </div>

                    <div>
                        <span class="text-danger">
                            @if ($errors->has("error"))
                            {{ $errors->first("error") }}
                            @endif
                        </span>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-danger" type="button" id="btn-submit" onclick="confirm('是否確認送出?') ? sendData() : ''">註冊</button>
                    </div>
                </form>

                <!-- FOOTER -->
                <div class="mt-4 text-center text-muted">
                    <span>© Copyright 2024 - The Pier</span> ·
                    <a href="#"><span>使用條款</span></a> ·
                    <a href="#"><span>隱私權政策</span></a>
                </div>
                <!-- FOOTER -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="/js/jquery-3.7.1.min.js"></script>
    <!-- toastify -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // JavaScript for form validation
    </script>
</body>
</html>