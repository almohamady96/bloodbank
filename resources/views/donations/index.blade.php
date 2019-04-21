@extends('layouts.app')
@inject('donation','App\DonationRequest')
@section('page_title')
    Donations
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">list of Donations</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @include('flash::message')
            @if (count($records))
                    <div class=table-responsive>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Patient_name</th>
                                <th>Patient_age</th>
                                <th>Blood_bags</th>
                                <th>Hospital_name</th>
                                <th>Hospital_address</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Blood_type</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                             </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{$record->patient_name}}</td>
                                <td class="text-center">{{$record->patient_age}}</td>
                                <td class="text-center">{{$record->bags_number}}</td>
                                <td class="text-center">{{$record->hospital_name}}</td>
                                <td class="text-center">{{$record->hospital_address}}</td>
                                <td class="text-center">{{$record->phone}}</td>
                                <td class="text-center">{{optional($record->city)->name}}</td>
                                <td class="text-center">{{$record->blood_type->name}}</td>
                                <td class="text-center">
                                    <a href="{{url(route('donation.edit',$record->id))}}" class="btn btn-success btn-xs">
                                        <i class="fa fa-edit"></i>  edit Donation</a>
                                </td>
                                <td class="text-center">
                                    {!!Form::open([
                                      'action' => ['DonationController@destroy',$record->id ],
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
