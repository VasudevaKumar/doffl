@extends('layouts.app')
@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> Edit Category</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        <label class="control-label">
            <a href="{{ route('admin.knowledgebase') }}" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.category.listCategory')</a>
        </label>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">

@endpush

@section('content')

    {!! Form::open(['id'=>'updateCategory','class'=>'ajax-form storeTicket','method'=>'POST']) !!}
    <div class="form-body">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">

                            <div class="row">

                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.client.companyName') <span class="text-danger">*</span></label>
                                        <br />
                                        <select class="selectpicker" data-width="fit" name="company_name">
                                                <option value="">Please choose</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" <?php if($company->id == $categoryRecord[0]->company_id) echo 'selected="selected"'?>>{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.category.categoryTitle') <span class="text-danger">*</span></label>
                                        <input type="text" id="subject" name="subject" class="form-control" value="<?php echo $categoryRecord[0]->title;?>" maxlength="250">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.category.categorySDescription') <span class="text-danger">*</span></label>
                                        <input type="text" id="shortDescription" name="shortDescription" name="subject" class="form-control" maxlength="250" value ="<?php echo $categoryRecord[0]->shortDescription;?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.category.categoryDescription') <span class="text-danger">*</span></label></label>
                                        <br>
                                        <textarea rows="10" cols="100" name="description"
                                                  id="description"><?php echo $categoryRecord[0]->description;?></textarea>
                                    </div>
                                </div>
                                <!--/span-->

                                {!! Form::hidden('status', 'open', ['id' => 'status']) !!}

                            </div>
                            <!--/row-->
                            <div class="row">
                                    <div class="col-md-6" style="margin-top:25px;">
                                       <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                     style="max-width: 300px; max-height: 50px; display:block !important; margin-left:8px !important;">
                                                     <img src="<?php echo url('/');?>/user-uploads/kbFiles/<?php echo $categoryRecord[0]->filePath;?>" style="width:50px; height:50px;">
                                                     </div>
                                                <div>
                                
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> @lang('app.selectFile') </span>
                                    <span class="fileinput-exists"> @lang('app.change') </span>
                                    <input type="file" id="image" name="image" accept="image/*"> </span>
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> @lang('app.remove') </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                        </div>
                    </div>

                   <div class="panel-footer text-right">
                        <div class="btn-group dropup">
                            <button aria-expanded="true" id="update-form" data-toggle="dropdown"
                                    class="btn btn-success dropdown-toggle waves-effect waves-light"
                                    type="button">@lang('app.submit') <span class="caret"></span></button>
                            
                            <input type="hidden" name="categoryID" value="<?php echo $categoryRecord[0]->id;?>">
                            <input type="hidden" name="existingFilePath" value="<?php echo $categoryRecord[0]->filePath;?>">
                        </div>
                    </div> 
                </div>


            </div>
            
        </div>
        <!-- .row -->
    </div>
    {!! Form::close() !!}

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="ticketModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

@endsection


@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>

<script>

    projectID = '';

    // $('.textarea_editor').wysihtml5();


    $('#update-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.knowledgebase.updateCategory')}}',
            container: '#updateCategory',
            type: "POST",
            redirect: true,
            blockUI: true,
            redirect: true,
            data: $('#updateCategory').serialize(),
            file: (document.getElementById("image").files.length == 0) ? false : true,
            success: function (response) {
               // if()
                // manage-files
               //  var url = '{{ route('admin.knowledgebase')}}';
                // location.href = url;
                    if(response.status == 'success')
                    {
                        var url = '{{ route('admin.knowledgebase')}}';
                        location.href = url;
                    }
                }
        })
    });

</script>
@endpush