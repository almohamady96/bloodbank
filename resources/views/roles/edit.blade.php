@extends('layouts.app')
@section('page_title')
    تعديل رتبه
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">

            <div class="box-body">
                {!!Form::model($model,[
      'action'=>['RoleController@update',$model->id],
      'method'=>'put'
      ])!!}
                @include('flash::message')
                @include('partials.validation_errors')
                @include('roles.form')
                {!!Form::close()!!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
