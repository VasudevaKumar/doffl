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
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        <label class="control-label">
            <a href="{{ route('admin.addpixel') }}" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.Pixels.addPixel')</a>
        </label>
        </div>

    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('plugins/image-picker/image-picker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/switchery/dist/switchery.min.css') }}">

@endpush


@section('content')


<div class="row">
    {!! Form::open(['id'=>'manageJobs','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="col-md-12">
            <div class="white-box">
                <div class="vtabs customvtab m-t-10">
                    @include('sections.admin_setting_menu')
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>Pixel Name</th>
                            <th>Pixel Code</th>
                                                      
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pixels as $key=>$pixel)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $pixel->pixelName }}</td>
                                <td>{{ $pixel->pixelCode }}</td>
                                
                                <td><button type="button" class="btn btn-default btn-sm" onClick="editPixel({{ $pixel->id }})">
                                              <span class="glyphicon glyphicon-user"></span> Edit
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm" onClick="deletePixel({{ $pixel->id }})">
                                              <span class="glyphicon glyphicon-user"></span> Delete
                                        </button>
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
                                            <div class="title m-b-15">@lang('messages.Recruit.noJobs')
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


@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


<script type="text/javascript">
    
 function editPixel(id)
{
      var url = '{{ route('admin.editPixel', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
}

function deletePixel(id)
{
    var  url = '{{route('admin.deletePixel')}}';
      var token = "{{ csrf_token() }}";

      $.easyAjax({
            type: 'POST',
            url: url,
            data: {'_token': token, 'id': id},
            success: function (response) {
                if (response.status == "success") {
                       window.location.reload();
                }
            }
        });
}


</script>




@endpush

<style type="text/css">
.smallfont{
    font-size:9px;
}
</style>