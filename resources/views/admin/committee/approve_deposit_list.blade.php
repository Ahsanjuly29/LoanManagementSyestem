@extends('layouts.admin.admin_list_template')

@section('content')
@include('partials.flash_success_msg')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table id="thisTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Loan Id</th>
                            <th>Loan Scheme</th>
                            <th>Loan Requested({!! trim($currency_symbol) !!})</th>
                            <th>Member</th>
                            <th>TPF No</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created On</th>
                            <th>Approved By</th>
                            <th>Approved On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($LoanDetails as $val)
                        <tr>
                            <td>{!! $val->id !!}</td>
                            <td>{!! $loan_scheme[$val->scheme_id] or '&mdash;' !!}</td>
                            <td>{!! $val->amount_requested !!}</td>
                            <td>{!! getCustomerName($val->Customer) !!}</td>
                            <td>{!! $val->Customer->tpf_number !!}</td>
                            <td>{!! $loan_status[$val->status] or '&mdash;' !!}</td>
                            <td>{!! getCustomerName($val->CreatedBy) !!}</td>
                            <td>{!! date('d-m-Y', strtotime($val->created_at)) !!}</td>
                            <td>{!! ($val->approved_by != '') ? getCustomerName($val->ApprovedBy) : '&mdash;' !!}</td>
                            <td>{!! ($val->approved_at != '') ? date('d-m-Y', strtotime($val->approved_at)) : '&mdash;' !!}</td>
                            <td>
                                @if($val->status==3)
                                <div class="col-xs-1"><i class="fa  fa-check-circle text-green"></i></div>
                                @elseif($val->status==1)
                                <div class="col-xs-1"><i class="fa  fa-check-circle text-blue"></i></div>
                                @elseif($val->status==2)
                                <div class="col-xs-1"><i class="fa  fa-remove text-red"></i></div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                <div class="col-xs-2"><i class="fa  fa-check-circle text-green"> {!! $loan_status[3] !!}</i></div>
                <div class="col-xs-2"><i class="fa  fa-check-circle text-blue"> {!! $loan_status[1] !!}</i></div>
                <div class="col-xs-2"><i class="fa  fa-remove text-red"> {!! $loan_status[2] !!}</i></div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
$(document).ready(function(){
    $("#thisTable").DataTable({
        "order": [],
        "aoColumnDefs": [{"bSortable": false, "aTargets": [10]}]
    });
});
</script>
@endsection
