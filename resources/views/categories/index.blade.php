@extends('layouts.app')

@section('page_title')
    categories
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="box">
<div class="box-header with-border">
    <h3 class="box-title">list of categories</h3>

    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
            <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
    </div>
</div>
<div class="box-body">
<a href="{{url(route('category.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i>  new categories</a>
@include('flash::message')
@if (count($categories))
<div class=table-responsive>
<table class="table table-bordered">
    <thead>
    <tr>
    <th>#</th>
    <th class="text-center">name</th>
        <th class="text-center">edit</th>
    <th class="text-center">delete</th>
     </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td class="text-center">{{$category->name}}</td>
        <td class="text-center">
            <a href="{{url(route('category.edit',$category->id))}}" class="btn btn-success btn-xs">
                <i class="fa fa-edit"></i>  edit categories</a>
        </td>
        <td class="text-center">
            <button id="{{$category->id}}" data-token="{{ csrf_token() }}" data-route="{{URL::route('category.destroy',$category->id)}}"  type="button" class="destroy btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
        </td>
        {{--
                                    <td class="text-center">
                                        {!!Form::open([
                                          'action' => ['CategoryController@destroy',$category->id ],
                                          'method' => 'delete',
                                          ])!!}
                                        <button class="btn btn-danger btn-xs" type="submit" id="delete"><i class="fa fa-trash-o"></i></button>
                                        {!!Form::close()!!}
                                    </td>
                                    --}}

    </tr>
</tbody>
@endforeach
</table>
</div>

@else
<div class="alert alert-danger" role="alert">
no data

</div>
@endif
</div>
<!-- /.box-body -->

</div>
<!-- /.box -->

</section>
<!-- /.content -->
@endsection
