@extends('Front.app')
@section('title', 'Member wishlist')
@section('content')
<div class='row w-100'>
    <!-- SideBar -->
    @include("Front.member.sidebar")
    <!-- Content -->
    <main class='col-md-9 ms-sm-auto mt-4 col-lg-10 px-md-4'>
        <div class='container'>
            <div class='card'>
                <ul class='list-group list-group-flush'>
                    <li class='list-group-item' data-id='{{ $data->listing_id }}'>
                        <div class='d-flex flex-column justify-content-between align-items-center my-3 px-md-5'>
                            <!-- 帳戶資料區塊 -->
                            <div class='mx-5 my-3 d-flex flex-column w-100'>
                                <h2 class='fw-bold text-lg'>帳戶資料</h2>
                                <div class='mb-3'><span class='text-muted text-sm'>在此修改您的姓名與 Email</span></div>
                                <div class='card'>
                                    <form action='/member/profile/account/update' method='post' id='form01'>
                                        {{ csrf_field() }}
                                        <div class='mx-5 my-4'>
                                            <div class='mb-3'>
                                                <div class="d-flex align-items-baseline">
                                                    <label for='form01-1' class='form-label fw-bold me-3'>姓名</label>
                                                    <span class='text-sm text-danger me-3' id='form01-1-msg'>
                                                    @if ($errors->has('form01_1'))
                                                        {{ $errors->first('form01_1') }}
                                                    @endif
                                                    </span>
                                                </div>
                                                <input type='text' class='form-control ' id='form01-1' name='form01_1' placeholder='name' value='{{ $data->name }}'>
                                            </div>
                                            <div class='mb-3'>
                                                <div class="d-flex align-items-baseline">
                                                    <label for='form01-2' class='form-label fw-bold me-3'>Email</label>
                                                    <span class='text-sm text-danger me-3' id='form01-2-msg'>
                                                    @if ($errors->has('form01_2'))
                                                        {{ $errors->first('form01_2') }}
                                                    @endif
                                                    </span>
                                                </div>
                                                <input type='email' class='form-control' id='form01-2' name='form01_2' placeholder='name@example.com' value='{{ $data->email }}'>
                                            </div>
                                            <input type='hidden' id='form01-id' name='form01_id' value='{{ $data->id }}'>
                                            <div class='text-end'>
                                                @if ($errors->has("errorF01"))
                                                    <span class='text-sm text-danger me-3' id='form01-return-msg'>{{ $errors->first("errorF01") }}</span>
                                                @endif
                                                <input type='submit' class='btn btn-danger' onclick='sendData("form01")' value='修改'>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- 修改密碼區塊 -->
                            <div class='mx-5 my-3 d-flex flex-column w-100'>
                                <h2 class='fw-bold text-lg'>修改密碼</h2>
                                <div class='mb-3'><span class='text-muted text-sm'>在此這修改您的密碼</span></div>
                                <div class='card'>
                                    <form action='/member/profile/password/update' method='post' id='form02'>
                                        {{ csrf_field() }}
                                        <div class='mx-5 my-4'>
                                            <div class="d-flex align-items-baseline">
                                                <label for='form02-1' class='form-label fw-bold me-3'>原密碼</label>
                                                <span class='text-sm text-danger' id='form02-1-msg'>
                                                @if ($errors->has('form02_1'))
                                                    {{ $errors->first('form02_1') }}
                                                @endif
                                                </span>
                                            </div>
                                            <div class='input-group mb-3'>
                                                <input type='password' class='form-control' id='form02-1' name='form02_1' placeholder='password' value='' aria-label='password' aria-describedby='addon-form02-1'>
                                                <span class='input-group-text text-center' id='addon-form02-1' onclick='toggleShowPwd("form02-1")' style='cursor: pointer; width: 3rem;'><i class="fa-solid fa-eye-slash"></i></span>
                                            </div>
                                            <div class="d-flex align-items-baseline">
                                                <label for='form02-2' class='form-label fw-bold me-3'>新密碼</label>
                                                <span class='text-sm text-danger' id='form02-2-msg'
                                                      data-msg01='密碼格式錯誤 (需介於 6-12 字)'
                                                      data-msg02='新舊密碼需不同'
                                                >
                                                @if ($errors->has('form02_2'))
                                                    {{ $errors->first('form02_2') }}
                                                @endif
                                                </span>
                                            </div>
                                            <div class='input-group mb-3'>
                                                <input type='password' class='form-control' id='form02-2' name='form02_2' placeholder='new password' value='' aria-label='password' aria-describedby='addon-form02-2'>
                                                <span class='input-group-text text-center' id='addon-form02-2' onclick='toggleShowPwd("form02-2")' style='cursor: pointer; width: 3rem;'><i class="fa-solid fa-eye-slash"></i></span>
                                            </div>
                                            <input type='hidden' id='form02-id' name='form02_id' value='{{ $data->id }}'>
                                            <div class='d-flex justify-content-between'>
                                                <div class='text-danger'>
                                                @if ($errors->has("errorF02"))
                                                    <span class='text-sm text-danger me-3' id='form02-return-msg'>{{ $errors->first("errorF02") }}</span>
                                                @endif
                                                </div>
                                                <input type='submit' class='btn btn-danger' onclick='sendData("form02")' value='修改'>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </main>
</div>

<script>
    const navbar = $('#navbar');
    const sidebar = $('#sidebar');
    sidebar.attr('style', `padding-top: ${navbar.outerHeight(true)}px`); // 設定側邊欄的 top 距離

    // 顯示/隱藏密碼
    function toggleShowPwd(inputId) {
        const pwdInput = document.getElementById(inputId);
        if (pwdInput.type === 'password') {
            pwdInput.type = 'text';
        } else {
            pwdInput.type = 'password';
        }
        // get child elements
        const eyeIcon = pwdInput.nextElementSibling.firstChild;
        console.dir(eyeIcon);
        if (eyeIcon.classList.contains('fa-eye-slash')) {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }

    var flag_name = false;
    var flag_email = false;
    var flag_pwd = false;
    var flag_pwd_new = false;
    var flag_pwd_chk = false;
    var emalReg = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    function sendData(formId) {
        event.preventDefault();
        let form = $('#' + formId);

        if (formId == 'form01') {
            flag_name = ($('#form01-1').val().length >= 3 && $('#form01-1').val().length <= 30);
            flag_email = emalReg.test($('#form01-2').val());
            if (flag_name == false) {
                $('#' + formId + '-1-msg').text('姓名字數需介於 3-30 字之間，只能輸入英數字和空白，不得包含特殊字元');
            } else {
                $('#' + formId + '-1-msg').text('');
            }
            if (flag_email == false) {
                $('#' + formId + '-2-msg').text('無效 Email 格式');
            } else {
                $('#' + formId + '-2-msg').text('');
            }
            // console.log(form);
            if (flag_name && flag_email) form.submit();
        } else if (formId == 'form02') {
            flag_pwd = ($('#form02-1').val().length > 0);
            flag_pwd_new = ($('#form02-1').val().length >= 6 && $('#form02-1').val().length <= 12);
            flag_pwd_chk = ($('#form02-1').val() != $('#form02-2').val());
            
            if (flag_pwd == false) { // 舊密碼長度錯誤
                $('#' + formId + '-1-msg').text('請輸入密碼');
            } else {
                flag_pwd = true;
                $('#' + formId + '-1-msg').text('');
            }
            if (flag_pwd_new == false) { // 新密碼長度錯誤
                $('#' + formId + '-2-msg').text($('#' + formId + '-2-msg').data('msg01'));
                return false;
            } else {
                flag_pwd_new = true;
                $('#' + formId + '-2-msg').text('');
            }
            if (flag_pwd_chk == false) { // 驗證新、舊密碼不同
                $('#' + formId + '-2-msg').text($('#' + formId + '-2-msg').data('msg02'));
                return false;
            } else {
                $('#' + formId + '-2-msg').text('');
            }

            if (flag_pwd && flag_pwd_new && flag_pwd_chk) {
                form.submit();
            } else {
                return false;
            }
        }
    }
</script>
@endsection