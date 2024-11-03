<header class='container-fluid sticky-top bg-white py-3 border-bottom z-3' id='navbar'>
    <div class='container d-flex justify-content-between align-items-center'>
        <!-- Logo and Text -->
        <div class='d-flex align-items-center'>
            <a href="/">
                <img src='/images/public/logo.png' alt='The Pier Logo' width='160' class='me-2'>
                <!-- <div>
            </div> -->
            </a>
        </div>
        
        <!-- Navigation -->
        <nav class='d-none d-md-flex justify-content-between'>
            @foreach($menus as $menu)
                @if($menu->types == 'U')
                <a href='{{ $menu->url }}' class='nav-link me-3'>{{ $menu->s1_name }}</a>
                @elseif($menu->types == 'G')
                    @if($menu->MenuS2->isNotEmpty())
                        <div class="dropdown" >
                            <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $menu->s1_name }}
                            </div>
                            <ul class="dropdown-menu">
                                @foreach($menu->MenuS2 as $child)
                                <li><a class="dropdown-item" href="{{ $child->url }}">{{ $child->s2_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
            @endforeach
            <div class='ms-3'>
                <a href='/advanced' class='nav-link text-danger fw-bold'>在 The Pier 瞧瞧進階功能 <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
        </nav>

        <!-- Auth Buttons -->
        @if(session()->has('username'))
        <div class='d-flex align-items-center'>
            <a href='/member/profile' class='text-decoration-none text-black'>
                <div class='d-flex align-items-center me-5'>
                    <div class='rounded-circle me-2' style='background-image: url("/images/member/avatar_01.jpg"); background-size: cover; height: 50px; width: 50px;'></div>
                    {{ session()->get('username') }}
                </div>
            </a>

            <a href='/logout' class='nav-link'>登出</a>
        </div>
        @else
        <div class='d-flex align-items-center'>
            <a href='/login' class='nav-link me-3'>登入</a>
            <a href='/signup' class='btn btn-danger rounded-pill ms-2'>註冊</a>
        </div>
        @endif

    </div>
</header>