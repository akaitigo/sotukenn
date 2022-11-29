<!-- 画面遷移テスト用 -->
{{-- @include('header') --}}
echo('あああああああああああああああああああああああああああああああああああああ');
@if(Auth::guard('parttimer')->check())
パートタイマーでログイン中
{{dump(Auth::guard('parttimer')->user()->name)}}
@elseif(Auth::guard('admin')->check())
アドミンでログイン中
{{dump(Auth::guard('admin')->user())}}
@elseif(Auth::guard('employee')->check())
社員でログイン中
{{dump(Auth::guard('employee')->user()->name)}}
@else
何かがおかしい
@endif

<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
</div>