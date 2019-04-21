@extends('layouts.app')

@section('page_title')
    governorates
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">list of governorates</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <a href="{{url(route('governorate.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i>  new governorate</a>
                @include('flash::message')
            @if (count($records))
                    <div class=table-responsive>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                            <th>#</th>
                            <th>name</th>
                            <th class="text-center">edit</th>
                            <th class="text-center">delete</th>
                             </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$record->name}}</td>
                                <td class="text-center">
                                    <a href="{{url(route('governorate.edit',$record->id))}}" class="btn btn-success btn-xs">
                                        <i class="fa fa-edit"></i>  edit governorate</a>
                                </td>
                                <td class="text-center">
                                    {!!Form::open([
                                      'action' => ['GovernorateController@destroy',$record->id ],
                                      'method' => 'delete'
                                      ])!!}
                                    <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                    {!!Form::close()!!}
                                </td>
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
