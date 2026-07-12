@extends('base')
<!--главный шаблон-->
@section('lk')
@stack('openMenu')
{!!$lk!!}
@endsection

@section('buttonLK')

    <div id="lk">
        
<button onclick="menuClick()">
    @if (empty($attr['id']))
    <img src="{{$site}}/assets/images/logo/user_off.png" height="70" width="70"/>
    @else
    <img src="{{$site}}/assets/images/logo/user_on.png" height="70" width="70"/>
    @endif
 </button>    
    </div>

@endsection
