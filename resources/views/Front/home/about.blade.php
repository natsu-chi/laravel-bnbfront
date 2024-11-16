@extends('Front.app')
@section('title', 'The Pier | About')
@section('content')
<!-- about 的 title CSS-->
<link rel="stylesheet" type="text/css" href="/css/about/about.css">
<!-- timeline -->
<link rel="stylesheet" type="text/css" href="/css/about/timeline.css">

<div data-scroll-watch='' class='fade_in title'>
    @if (!empty(session()->get('bannerAbout')))
    <div class='top_banner' style='height: 50vh; max-height: 300px;'>
        <img src='/images/about/{{ session()->get("bannerAbout") }}' alt='About' class='bg-cover'>
    </div>
    @endif
</div>
<div data-scroll-watch='' class='fade_in esontea mt-5'>
    <section data-scroll-watch='' class='fade_in'>
        <p class='subtitle'>
            @foreach($aboutTitle as $data)
                @if ($data->type_id == 1)
                    {!! $data->content !!}
                    @break
                @endif
            @endforeach
        </p>
    </section>
</div>
@foreach($aboutTitle as $data)
    @continue($data->type_id != 2)
<div data-scroll-watch='' class='fade_in content_title'>
    <h2 class='main_title'>{{ $data->title }}</h2>
    <div class='subtitle'>{!! $data->content !!}</div>
</div>
@endforeach

@if (!empty($about) && sizeof($about)>0)
<div class='invisible' id='featured'></div>
<div class='idea row'>
    @foreach($about as $data)
    <section data-scroll-watch='' class='fade_in col me-3'>
        @if (!empty($data->photo))
        <img src='/images/about/{{ $data->photo }}' class='bg-cover img-thumbnail' style='width: 200px; height: 200px;'>
        @endif
        <h4 class='main_title'>{{ $data->item_name }}</h4>
        <p class='subtitle'>{{ $data->content }}</p>
    </section>
    @endforeach
</div>
@endif

@foreach($aboutTitle as $data)
    @continue($data->type_id != 3)
<div data-scroll-watch='' class='fade_in content_title'>
    <h2 class='main_title'>{{ $data->title }}</h2>
    <div class='subtitle'>{!! $data->content !!}</div>
</div>
@endforeach

@if (!empty($advance) && sizeof($advance)>0)
<div class='strength'>
    @foreach($advance as $data)
    <section data-scroll-watch='' class='fade_in'>
        @if (!empty($data->photo))
        <img src='/images/about/{{ $data->photo }}'>
        @endif
        <h3 class='main_title'>{{ $data->item_name }}</h3>
        <p class='subtitle text-center'>{{ $data->content }}</p>
    </section>
    @endforeach
</div>
@endif

@foreach($aboutTitle as $data)
    @continue($data->type_id != 4)
<div data-scroll-watch='' class='fade_in content_title'>
    <h2 class='main_title'>{{ $data->title }}</h2>
    <div class='subtitle'>{!! $data->content !!}</div>
</div>
@endforeach
@if (!empty($event) && sizeof($event))
<div data-scroll-watch='' class='fade_in eson_timeline'>
    <div class='col-md-12'>
        <div class='main-timeline'>
            @php $cnt = 0 ; @endphp
            @foreach($event as $data)
                @php $cnt++ ; @endphp
            <div class='timeline'>
                <div class='timeline-icon'></div>
                <div class='timeline-content{{ $cnt % 2 == 0 ? ' right' : '' }}'>
                    <h2 class='title'>{{ date('Y', strtotime($data->dates)) }}</h2>
                    <p class='description'>{{ $data->content }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection