@extends('layouts.app')
@inject('client','App\Client')
@inject('donation','App\DonationRequest')
@inject('governorates','App\Governorate')
@inject('cities','App\City')
@inject('categories','App\Category')
@inject('posts','App\Post')
@inject('contact','App\Contact')
@section('page_title')
    Blood Bank
@endsection
@section('small_title')
    statistics
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">العملاء</span>
                        <span class="info-box-number">{{$client->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-line-chart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">التبرعات</span>
                            <span class="info-box-number">{{$donation->count()}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-purple"><i class="ion-ios-home"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">المحافظات</span>
                        <span class="info-box-number">{{$governorates->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-navy"><i class="ion ion-flag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">المدن</span>
                        <span class="info-box-number">{{$cities->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-olive-active"><i class="fa fa-list-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">الأقسام</span>
                        <span class="info-box-number">{{$categories->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-teal"><i class="fa fa-newspaper-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">المقالات</span>
                        <span class="info-box-number">{{$posts->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red-active"><i class="fa fa-envelope"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">تواصل معنا</span>
                        <span class="info-box-number">{{$contact->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            {{--<div class="col-md-3 col-sm-6 col-xs-12">--}}
            {{--<div class="info-box">--}}
            {{--<span class="info-box-icon bg-aqua-active"><i class="fa fa-file"></i></span>--}}

            {{--<div class="info-box-content">--}}
            {{--<span class="info-box-text">التفارير</span>--}}
            {{--<span class="info-box-number">{{$donation->count()}}</span>--}}
            {{--</div>--}}
            {{--<!-- /.info-box-content -->--}}
            {{--</div>--}}
            {{--<!-- /.info-box -->--}}
            {{--</div>--}}
        </div>


        <!-- Default box -->
        {{--<div class="box">--}}
        {{--<div class="box-header with-border">--}}
        {{--<h3 class="box-title">Title</h3>--}}

        {{--<div class="box-tools pull-right">--}}
        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
        {{--title="Collapse">--}}
        {{--<i class="fa fa-minus"></i></button>--}}
        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"--}}
        {{--title="Remove">--}}
        {{--<i class="fa fa-times"></i></button>--}}
        {{--</div>--}}
        {{--</div>--}}


            <div class="box-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                   {{-- You are logged in!--}}

            </div>
            <!-- /.box-body -->
               {{-- <div class="box-footer">--}}
              {{--  Footer--}}
               {{--</div>--}}
                <!-- /.box-footer-->
               {{--</div>--}}
                <!-- /.box -->

</section>
<!-- /.content -->
@endsection
