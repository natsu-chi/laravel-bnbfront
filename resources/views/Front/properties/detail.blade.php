@extends('Front.app')
@section('title', 'The Pier | 房型資料立即查看')
@section('content')
<style>
    .listing-title {
        font-size: 24px;
        font-weight: bold;
    }

    .rating {
        color: #ff5a5f;
    }

    .price-box {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .property-details {
        margin-top: 20px;
    }

    .main-image img {
        width: 100%;
        height: auto;
    }

    .gallery img {
        height: 100px;
        object-fit: cover;
        width: 100%;
    }

    .gallery .col {
        padding-right: 5px;
    }

    .gallery .see-all {
        position: absolute;
        top: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 10px;
        color: white;
    }
</style>

<div class='container'>
    @if(isset($data))
    <div class='row'>
        <!-- Main Section -->
        <div class='col-lg-8'>
            <!-- Location 城市 -->
            <p class='text-muted'><a href='/properties/search?location=1&checkin=&checkout=&adults=2'>{{ $cityInfo->name }}, {{ $cityInfo->country_short_name }}</a></p>

            <!-- Title and Rating -->
            <div>
                <h1 class='fw-bold text-2xl'>{{ $data->name }}</h1>
                <div class='rating'>
                    <span>★★★★★</span> <span>(1 review)</span>
                </div>
            </div>

            <!-- Image Gallery -->
            @php
            if (!isset($data->picture_url)) {
                $img = 'https://placehold.co/800x400/EEE/31343C?font=montserrat&text=No images now';
            } else
            {
                $img = $data->picture_url;
            }
            @endphp
            <div class='row mt-3'>
                <div class='col-12 main-image vh-100 bg-cover bg-position-center'
                    style='background-image: url("{{ $img }}"); max-height: 400px;'>
                </div>
            </div>

            <!-- 房屋資訊區塊 -->
            <div class='row mt-4 text-center'>
                <div class='col'>
                    <p><strong>類型</strong></p>
                    <p>{{ $data->room_type }}</p>
                </div>
                <div class='col'>
                    <p><strong>{{ number_format($data->bedrooms, 0) }} 間房間</strong></p>
                    <p>容納 {{ $data->accommodates }} 人</p>
                </div>
                <div class='col'>
                    <p><strong>衛浴設備</strong></p>
                    <p>{{ $data->bathrooms_text }}</p>
                </div>
            </div>

            <!-- 關於區塊 -->
            <div class='mt-4'>
                <h3 class="text-xl fw-bold">房源介紹</h3>
                <div class='overflow-y-hidden' id='sec-of01' style='max-height: 6rem;'>{!! $data->description !!}</div>
                @if(strlen($data->description) > 100)
                <a href='javascript:void(0)' onclick='show("sec-of01")' class='text-sm text-danger' id='link-show-sec-of01'>顯示更多</a>
                @endif
            </div>

            <!-- 設施區塊 -->
            <div class='amenities mt-4'>
                <h3 class='text-xl fw-bold'>房源設備</h3>
                <ul class='ps-0 overflow-y-hidden' id='sec-of02' style='max-height: 110px;'>
                    @php
                    $amenitiesArr = json_decode($data->amenities, true);
                    @endphp
                    @foreach ($amenitiesArr as $amenity)
                    <li>{{ $amenity }}</li>
                    @endforeach
                </ul>
                <a href='javascript:void(0)' onclick='show("sec-of02")' class='text-sm text-danger' id='link-show-sec-of02'>顯示更多</a>
            </div>
        </div>
        <!-- Sidebar 價格 -->
        <div class='col-lg-4 mt-lg-5 border-bottom'>
            <!-- Wishlist Form -->
            <div class='mb-4 d-flex justify-content-end {{ (session()->get("member"))?"":"invisible" }}'>
                <button class='btn btn-primary'>
                    <i class='fa-solid fa-heart mr-2'></i>
                    加入收藏
                </button>
            </div>
            <div>
                <div class='fw-bolder mb-3' class='text-sm'>平均 <span class='text-3xl'>${{ number_format($data->price, 0) }}</span> / 晚</div>
                <div class='price-box text-center'>
                    <div>
                        <!-- <div class='mb-3'>
                            <label for='checkIn' class='form-label'>Check In</label>
                            <input type='date' class='form-control' id='checkIn' disabled>
                        </div>
                        <div class='mb-3'>
                            <label for='checkOut' class='form-label'>Check Out</label>
                            <input type='date' class='form-control' id='checkOut' disabled>
                        </div> -->
                        <div class='d-flex justify-content-center align-items-center' style='min-height: 200px'>
                            <a href='{{ $data->listing_url }}' class='btn btn-lg btn-danger rounded-pill' target='_blank'>前往比價</a>
                        </div>
                        <p class='text-muted mt-3'>您將會前往外部網站比價</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class='row' style='height: 80vh; overflow: hidden;'>
        <div class='col-4 fw-bold display-4 text-center d-flex flex-column justify-content-center ubuntu-regular'>
            <p style='color: #465a65;'>找不到資料</p>
            <a href="/" class='text-base'><i class="fa-solid fa-arrow-left"></i> 返回首頁</a>
        </div>
        <div class='col-8' style='background-image: url("/images/properties/search_data-not-found.svg"); background-size: cover; background-position: center;'></div>
    </div>
    @endif
</div>
<script>
    function show(id) {
        $('#' + id).removeClass('overflow-y-hidden');
        $('#' + id).attr('style', '');
        $('#link-show-' + id).hide();
    }
</script>
@endsection