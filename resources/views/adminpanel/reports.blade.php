@extends('adminpanel.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <div class="row ">
            <div class="col-md-12 pl-3 pt-2" style="margin: auto;">
                <div class="card" style="width: 100%">
                    <div class="card-header" style="background: white;">
                        <div class="row ">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="col-md-12 px-3 pt-2">
                                <div class="d-flex justify-content-between align-items-center mr-2">
                                    <h5>Sales Report</h5>

{{--                                                                        <a href=""><button class="btn-primary">Customer Sync</button></a>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="product_append">
                            <div class="row px-3" style="overflow-x:auto;">

                                <table id="datatabled" class="table table-hover table-class ">
                                    <thead class="border-0 ">
                                    <tr class="th-tr table-tr ">
                                        <th class="font-weight-bold w-50" >Report Name</th>
                                        <th class="font-weight-bold w-25" >Date</th>
                                        <th class="font-weight-bold w-25" >Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($report_data))
                                        @foreach($report_data as $key=>$report)
                                            <tr class="td-text-center">
                                                <td scope="row">
                                                    <a href="{{route('report-detail', $report->id)}}">{{$report->report_name}}</a>
                                                </td>
                                                <td scope="row">
                                                    <a href="{{route('report-detail', $report->id)}}">{{$report->date}}</a>
                                                </td>
                                                <td scope="row">
                                                    <div class="btn-group btn-group-sm float-right">
                                                        <a href="{{route('report-detail', $report->id)}}"><button type="submit" class="btn btn-sm btn-primary">View</button></a>
                                                        <a href="{{route('report-delete', $report->id)}}"><button type="submit" class="btn btn-sm btn-danger DeleteBtn">Delete</button></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
{{--                                @if(count($report_data))--}}
{{--                                    {!!  $report_data->links() !!}--}}
{{--                                @endif--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
