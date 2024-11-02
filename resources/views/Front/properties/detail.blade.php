@extends('Front.app')
@section('title', 'The Pier | 房型資料立即查看')
@php
    $useLeaflet = true;
@endphp
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
                    @if (isset($review))
                    <span class='fw-bold'>★ {{ $review->review_scores_rating }}</span> <span>({{ count($comments) }} 則評論)</span>
                    @else
                    <span class='fw-bold'>★ (暫無評分)</span>
                    @endif
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

            <!-- 留言區塊 -->
            <div class='mt-4'>
                <h3 class='text-xl fw-bold'>{{ count($comments) }} 則評論</h3>
                @for ($i = 0; $i < min(2, count($comments)); $i++)
                    <div class='border rounded p-3 mt-3'>
                        <p class='fw-bold'>{{ $comments[$i]->reviewer_name}}&emsp;&emsp;</p>
                        <p>{!! $comments[$i]->comments !!}</p>
                        <span class='text-sm fw-normal text-muted'>{{ $comments[$i]->date}}</span>
                    </div>
                @endfor
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-sm btn-outline-danger mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    顯示全部
                </button> 
            </div>

            <!-- 地圖區塊 -->
            <div class='mt-4'>
                <h3 class='text-xl fw-bold'>住宿地點</h3>
                <div class="z-1">
                    <div id="map" style='height: 60vh;max-height: 500px;'></div>
                </div>
            </div>
            
        </div>

        <!-- Sidebar 價格 -->
        <div class='col-lg-4 mt-lg-5 border-bottom'>
            <!-- Wishlist Form -->

            <div class='mb-4 d-flex justify-content-end'>
                @if (isset($likedItem) && (session()->get("memberId")))
                <button data-status='1' class='btn btn-outline-danger' id='btn-like'>
                    <i class='fa-solid fa-heart me-1' id='icon-like'></i>
                    <span id='btn-like-text'>已收藏</span>
                </button>
                @else
                <button data-status='0' class='btn btn-outline-danger' id='btn-like'>
                    <i class='fa-regular fa-heart me-1' id='icon-like'></i>
                    <span id='btn-like-text'>加入收藏</span>
                </button>
                @endif
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

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">評論內容</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @foreach ($comments as $comment)
                <div class='border rounded p-3 mt-3'>
                    <p class='fw-bold'>{{ $comment->reviewer_name}}&emsp;&emsp;</p>
                    <p>{!! $comment->comments !!}</p>
                    <span class='text-sm fw-normal text-muted'>{{ $comment->date }}</span>
                </div>
            @endforeach
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        </div>
        </div>
    </div>
    </div>
</div>
<script>
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var like = $('#btn-like').data('status');
    $(document).ready(function() {
        // 分類資料
        propertyData = @json($data);
        renderMap(new Array(propertyData));

        $('#btn-like').click(function () {
            let url = '';
            if (like == 0) {
                url = '/member/wishlist/add';
            } else {
                url = '/member/wishlist/delete';
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    'listing_id': {{ $data->id }},
                    '_token': csrfToken
                },
                dataType: 'json',
                success: function(res) {
                    // 切換按鈕狀態
                    like = (like == 1) ? 0 : 1;
                    renderLikeBtn(like);
                },
                error: function(error) {
                    alert(`error- ${url}`);
                }
            });
        });
    });

    function show(id) {
        $('#' + id).removeClass('overflow-y-hidden');
        $('#' + id).attr('style', '');
        $('#link-show-' + id).hide();
    }

    // 產生地圖
    function renderMap(dataList) {
        // 最初水滴座標
        map = L.map('map').setView([dataList[0].latitude, dataList[0].longitude], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        map.panTo([dataList[0].latitude, dataList[0].longitude]);

        appendToMap(dataList);
    }

    function appendToMap(dataList) {
        $.each(dataList, function(i, item) {
            L.marker([item.latitude, item.longitude]).addTo(map)
                .bindPopup(
                    '<div class="card" style="width: 15rem;">' +
                    '<img src="' + item.picture_url + '" class="card-img-top bg-cover" alt="" style="max-height: 8rem;" onError="this.onerror=null; this.src=\'/images/settings/no_image.jpg\'" >' +
                    '<div class="card-body">' +
                    '<div class="d-flex justify-content-between align-items-center">' +
                    '<span class="badge text-bg-primary">' + item.neighbourhood_cleansed + '</span>' +
                    (item.liked === 'Y' ?
                        '<i class="fa-solid fa-bookmark" onclick="toggleLike(\'N\')" style="cursor: pointer"></i>' :
                        '<i class="fa-regular fa-bookmark" onclick="toggleLike(\'Y\')" style="cursor: pointer"></i>') +
                    '</div>' +
                    '<div class="text-truncate">' +
                    '<a href="' + item.listing_url + '" target="_blank">' + item.name + '</a>' +
                    '</div>' +
                    '<div class="row text-truncate">' +
                    '<div class="col-md-3 text-sm text-muted">建築類型</div>' +
                    '<div class="col-md-9 text-sm text-muted text-end">' + item.property_type + '</div>' +
                    '</div>' +
                    '<div class="row text-truncate">' +
                    '<div class="col-md-3 text-sm text-muted">房間類型</div>' +
                    '<div class="col-md-9 text-sm text-muted text-end">' + item.room_type + '</div>' +
                    '</div>' +
                    '<div class="row text-truncate">' +
                    '<div class="col text-sm fw-bold">$' + ((item.price == null) ? '--' : Math.floor(parseFloat(item.price)).toLocaleString()) + ' 晚</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                );
        });

        markers = new L.markerClusterGroup().addTo(map);
    }

    function renderLikeBtn(status) {
        if (status == 1) {
            $('#icon-like').removeClass('fa-regular');
            $('#icon-like').addClass('fa-solid');

            $('#btn-like-text').text('已收藏');
            $('#btn-like').attr('data-status', '1');
        } else {
            $('#icon-like').removeClass('fa-solid');
            $('#icon-like').addClass('fa-regular');

            $('#btn-like-text').text('加入收藏');
            $('#btn-like').attr('data-status', '0');
        }
    }
</script>
@endsection