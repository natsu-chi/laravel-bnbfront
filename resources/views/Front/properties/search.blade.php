@extends('Front.app')
@section('title', 'Search Results')
@section('content')
<!-- 地圖 JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="/js/leaflet.markercluster.js"></script>

<style>
    .list-item-img {
        height: 160px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6 vh-100 overflow-y-scroll">
            @foreach ($list->chunk(10) as $chunkIndex => $chunk)
                <div class="data-group {{ $chunkIndex > 0 ? 'd-none' : '' }}" id="p-{{ $chunkIndex }}">
                    @foreach ($chunk as $data)
                    <div class="col-md-12 border-bottom">
                        <a href="/properties/{{ $data->id }}" style="text-decoration: none; color: inherit;">
                            <div class="row my-3">
                                <div class="col-md-4">
                                    <div class="img-fluid bg-cover bg-position-center list-item-img rounded" style="background-image: url('{{ $data->picture_url }}');"></div>
                                </div>
                                <div class="col-md-8 d-flex flex-column justify-content-around text-break">
                                    <div class="row">
                                        <div class="col">
                                            <div class="text-sm text-muted">位於 {{ $data->neighbourhood_cleansed }} 的 {{ $data->property_type }}</div>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-neutral-900 text-base">{{ $data->name }}</div>
                                    <div class="text-sm text-muted">{{ $data->bedrooms }} bedrooms • {{ $data->bathrooms_text }} • {{ $data->accommodates }} guests</div>
                                    <div class="fw-bolder text-xl">${{ ($data->price > 100) ? (number_format($data->price, 0)) : '--' }} <span class="text-sm text-muted">/ 平均每晚</span></div>
                                    <div>
                                        <button class="btn btn-primary">查看詳情</button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            @endforeach
            <button type="button" class="btn btn-danger" onclick="loadmore();">載入更多</button>
        </div>
        <div class="col-md-6 z-1">
            <div class="vh-100" id="map"></div>
        </div>
    </div>
</div>
<script>
    var loadedGroupIdx = 0;
    var propertyData = []; // 存放後端傳送資料
    var listToMap;         // 顯示在地圖資料
    var map;               // 地圖
    var markers;           // 座標

    $(document).ready(function() {
        // 分類資料
        propertyData = @json($list);
        listToMap = propertyData.slice(0, 10);

        renderMap(listToMap);
    });

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
        console.log(dataList);
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

    // 清除所有的水滴座標
    function removeMaker() {
        map.eachLayer(function(layer) {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer)
            }
        });
    }

    // 分頁顯示列表資料
    function loadmore() {
        loadedGroupIdx++;
        $(`#p-${loadedGroupIdx}`).removeClass('d-none');
        listToMap = propertyData.slice(loadedGroupIdx*10, loadedGroupIdx*10+10);
        appendToMap(listToMap);
    }
</script>
@endsection