<!-- 画面遷移テスト用 -->
@include('header')
echo('あああああああああああああああああああああああああああああああああああああ');
@if(Auth::guard('parttimer')->check())
{{dump(Auth::guard('parttimer')->user()->name)}}
<a herf="{{ route('calendar') }}" class="nav-link"><span>カレンダー</span></a>
@elseif(Auth::guard('admin')->check())
{{dump(Auth::guard('admin')->user()->name)}}
@elseif(Auth::guard('employee')->check())
{{dump(Auth::guard('employee')->user()->name)}}
@else
何かがおかしい
@endif
{{dump(Auth::check())}}
