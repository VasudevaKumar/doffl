@extends('layouts.app')
@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> Create Article</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        <label class="control-label">
            <a href="#" onClick="gotoListArticles('<?php echo $categories[0]->id;?>')" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i>Article List</a>
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

    {!! Form::open(['id'=>'storeArticle','class'=>'ajax-form storeTicket','method'=>'POST']) !!}
    <div class="form-body">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">

                            <div class="row">

                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo $categories[0]->title. ' category';?> <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.category.articleTitle') <span class="text-danger">*</span></label>
                                        <input type="text" id="articleSubject" name="articleSubject" class="form-control" maxlength="250">
                                        <input type="hidden" name="categoryID" value="<?php echo $categories[0]->id;?>"/>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.category.articleShortDescription') <span class="text-danger">*</span></label>
                                        <input type="text" id="articleShortDescription" name="articleShortDescription" class="form-control" maxlength="250">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.category.articleDescription') <span class="text-danger">*</span></label></label>
                                        <br>
                                        <textarea class="textarea_editor form-control" rows="10" name="articleDescription"
                                                  id="articleDescription"></textarea>
                                    </div>
                                </div>
                                <!--/span-->

                                {!! Form::hidden('status', 'open', ['id' => 'status']) !!}

                            </div>
                            <!--/row-->

                        </div>
                    </div>

                   <div class="panel-footer text-right">
                        <div class="btn-group dropup">
                            <button aria-expanded="true" id="save-form" data-toggle="dropdown"
                                    class="btn btn-success dropdown-toggle waves-effect waves-light"
                                    type="button">@lang('app.submit') <span class="caret"></span></button>
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

    $('.textarea_editor').wysihtml5();


    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.knowledgebase.saveArticle')}}',
            container: '#storeArticle',
            type: "POST",
            redirect: true,
            blockUI: true,
            redirect: true,
            data: $('#storeArticle').serialize(),
            success: function (response) {

                console.log(response);
               // if()
                // manage-files
               //  var url = '{{ route('admin.knowledgebase')}}';
                // location.href = url;
                    if(response.status == 'success')
                    {
                    
                    let catID = response.categoryID;
                     var url = '{{ route('admin.knowledgebase.manageArticles', ':catID')}}';
                     url = url.replace(':catID', catID);
                     location.href = url;
                    }
                }
        })
    });

    function gotoListArticles(categoryID)
    {
        var url = '{{ route('admin.knowledgebase.manageArticles', ':categoryID')}}';
            url = url.replace(':categoryID', categoryID);
        location.href = url;
    }
</script>
@endpush