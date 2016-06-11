@extends('main_layout')
@section('content')
<div id="wrapper">
    @include("panel.nav")
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-camera" aria-hidden="true"></i> My Photo
                    </div>
                    <div class="panel-body">
                        @foreach($data as $key => $value)
                            <div class="col-xs-6 col-md-2">
                                <div class="thumbnail">
                                    <div class="col-lg-12" style="background: #000; text-align: center;">
                                        <img src="{{ $value['images']['thumbnail']['url'] }}" alt="...">
                                    </div>
                                    <br />
                                    <div class="col-lg-12">
                                        <i class="fa fa-heart" aria-hidden="true" style="color:#f00"></i> {{$value['likes']['count']}}
                                        <i class="fa fa-comment-o" aria-hidden="true"></i> {{$value['comments']['count']}}
                                    </div>
                                    <div class="caption">
                                        @if(strlen($value['caption']['text']) > 0)
                                            <p>{{ str_limit($value['caption']['text'], 10) }}</p>
                                        @else
                                            <p>{{ 'NO CAPTION' }}</p>
                                        @endif
                                    </div>
                                    <a href="/telegram/send?comment={{$value['comments']['count']}}&like={{$value['likes']['count']}}&photo={{$value['images']['standard_resolution']['url']}}&caption={{urlencode($value['caption']['text'])}}&mediaid={{ $value['id'] }}" type="button" class="btn btn-info" style="width: 100%;">Send To Telegram Channel</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
@endsection