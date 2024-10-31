@extends('Front.app')
@section('title', 'Error 404')
@section('content')
<div class='container'>
    <div class='row' style='height: 80vh; overflow: hidden;'>
        <div class='col fw-bold display-1 text-center d-flex flex-column justify-content-center ubuntu-regular'>
            <p style='color: #465a65;'>PAGE</p>
            <p style='color: #fdc727;'>404</p>
            <a href="javascript:history.back()" class='text-base'><i class="fa-solid fa-arrow-left"></i> 回上一頁</a>
        </div>
        <div class='col vh-100' style='background-image: url("/images/errors/error404.svg"); background-size: cover; background-position: center;'></div>
    </div>

</div>
@endsection