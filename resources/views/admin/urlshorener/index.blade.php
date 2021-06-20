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
    </div>
@endsection



@section('content')

<iframe src="http://<?php echo $_SERVER['HTTP_HOST'];?>/urlshorten/admin/index.php?company_id=<?php echo $company_id;?>" name="myFrame" style="border:none; width:100%; height: 100%;"></iframe>

@endsection


@push('footer-script')


@endpush

<style type="text/csss">

  
</style>
<style type="text/css">
    .container-fluid{
        padding-left: 5px !important;
    }
</style>