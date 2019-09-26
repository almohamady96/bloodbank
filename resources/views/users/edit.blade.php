@extends('layouts.app')
@section('page_title')
    edit users
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">

            <div class="box-body">
                {!!Form::model($model,[
      'action'=>['UserController@update',$model->id],
      'method'=>'put'
      ])!!}
                @include('flash::message')
                @include('partials.validation_errors')
                @include('users.form')

                {!!Form::close()!!}

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
