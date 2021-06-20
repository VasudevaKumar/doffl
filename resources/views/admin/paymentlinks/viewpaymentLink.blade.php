@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->

        <!-- /.breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        <label class="control-label">
            <a href="{{ route('admin.paymentLinks') }}" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.Paymentlinks.Paymentlinks')</a>
        </label>
        </div>

    </div>
@endsection

@section('content')

<div class="row">
    {!! Form::open(['id'=>'manageBookings','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="col-md-12">
            <div class="white-box">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>@lang('modules.Bookings.name')</th>
                            <th>@lang('modules.Bookings.email')</th>
                            <th>@lang('modules.Bookings.phone')</th>
                            <th>@lang('modules.Bookings.trasactionStatus') </th>
                            <th>@lang('modules.Bookings.trasactionID')</th>
                            <th>@lang('modules.Bookings.paymentType')</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($paymentlinkLeads as $key=>$paymentlinkLead)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $paymentlinkLead->name }}</td>
                                <td>{{ $paymentlinkLead->email }}</td>
                                <td>{{ $paymentlinkLead->phone }}</td>
                                <td>{{ $paymentlinkLead->trasactionStatus }}</td>
                                <td>{{ $paymentlinkLead->trasactionID }}</td>
                                <td>{{ $paymentlinkLead->paymentType }}</td>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    <div class="empty-space" style="height: 200px;">
                                        <div class="empty-space-inner">
                                            <div class="icon" style="font-size:30px"><i
                                                        class="icon-layers"></i>
                                            </div>
                                            <div class="title m-b-15">No records exists
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       
        {!! Form::close() !!}

                 

    </div>
    <!-- .row -->


@endsection



<!-- The Modal -->
                <div id="myModal" class="modal">

                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <p><div id="dynamicContent">Some text in the Modal..</div></p>
                  </div>

                </div>

@push('footer-script')



@endpush

