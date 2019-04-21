@extends('layouts.app')
@inject('model','App\City')
@section('page_title')
   create cities
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">create cities</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::open([
                 'action' => 'PostController@store',
                 'files'=>   true,
                 'method' => 'post',
                 'enctype' =>'multipart/form-data'
                 ]) !!}
                @include('partials.validation_errors')
                <div class="form-group">
                    <label for="name">Title</label>
                    {!! Form::text('title',null,[
                    'class' => 'form-control'
                 ]) !!}
                    <label for="name">Content</label>
                    {!! Form::text('content',null,[
                    'class' => 'form-control'
                 ]) !!}
                    <label class="form-control" for="image">Choose an image : </label>
                    {!! Form::file('image', [
                    'class'=>'form-control'

                   ]) !!}

                    <label class="form-control" for="select">Select the category:</label>
                    {!! Form::select('category_id',$categories,null,[
                        'class' => 'form-control'
                     ]) !!}
                    <label class="form-control" for="puplish_date">Publish date :  </label>
                    {{ Form::date('puplish_date', \Carbon\Carbon::now(), [
                    'class' => 'form-control'
                    ]) }}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit"> Create</button>
                </div>

                {!! Form::close () !!}
            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
