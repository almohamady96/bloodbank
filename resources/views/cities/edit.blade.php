@extends('layouts.app')
@section('page_title')
    edit cities
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">edit cities</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!!Form::model($model,[
      'action'=>['CityController@update',$model->id],
      'method'=>'put'
      ])!!}
                @include('flash::message')
                @include('partials.validation_errors')
                <div class="form-group">
                    <label for="name">Name</label>
                    {!! Form::text('name',null,[
                    'class' => 'form-control'
                 ]) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>                {!!Form::close()!!}

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
