@extends('home.ydzshome.header')
@section('content')
<div class="std"><div class="xf-list">
<div class="empty_cart">
<img src="{{ asset('/img/site_img/errorpage.png')}}" alt="404" />
<p><a href="/" class="org_btnb index_btn">返回首頁</a></p>
</div>
</div>
<style>.empty_cart,.empty_cart img{width:100%}.empty_cart{position:relative;}.index_btn{background:#e40681;height:32px;line-height:32px;padding:0 25px;}.empty_cart p{position:absolute;left:50%;top:60%;}</style></div>
@endsection