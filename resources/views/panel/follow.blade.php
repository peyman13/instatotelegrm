@extends('main_layout')
@section('content')
<div id="wrapper">
    @include("panel.nav")
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{$title}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa fa-link"></i> {{$title}}
                    </div>
                    <div class="panel-body">
                        @foreach($data as $k => $value)
                            <div class="col-xs-6 col-md-2">
                                <div class="thumbnail">
                                    <div class="col-lg-12" style="background: #000; text-align: center;">
                                        <img src="{{$value['profile_picture']}}">
                                    </div>
                                    <div>
                                        {{ $value['username'] }}
                                    </div>    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection