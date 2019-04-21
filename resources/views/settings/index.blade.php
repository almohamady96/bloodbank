@extends('layouts.app')
@section('page_title')
    settings
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::model($model,[
                'action' => ['SettingController@update',$model->id],
                'method' =>'put'
                ]) !!}
                @include('partials.validation_errors')
                @include('flash::message')
                <div class="form-group">
                    <label for="name">facebook_url</label>
                    {!! Form::text('facebook_url',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="name">twitter_url</label>
                    {!! Form::text('twitter_url',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>

                <div class="form-group">
                    <label for="name">youtube_url</label>
                    {!! Form::text('youtube_url',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="name">instagram_url</label>
                    {!! Form::text('instagram_url',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>

                <div class="form-group">
                    <label for="name">google_url</label>
                    {!! Form::text('google_url',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="name">whatsapp_url</label>
                    {!! Form::text('whatsapp_url',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="name">about_app</label>
                    {!! Form::text('about_app',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="name">android_app_url</label>
                    {!! Form::text('android_app_url',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="name">email</label>
                    {!! Form::text('email',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="name">phone</label>
                    {!! Form::text('phone',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"> Update</button>
                    </div>
                </div>


                {!! Form::close () !!}

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
