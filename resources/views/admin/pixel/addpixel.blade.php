@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i>Add Pixels</h4>
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
            <a href="{{ route('admin.pixel') }}" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.Pixels.listPixel')</a>
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
@endpush

@section('content')

<div class="row">
        <div class="col-md-12">

            <div class="vtabs customvtab m-t-10">
                    @include('sections.admin_setting_menu')
                </div>


            <div class="panel panel-inverse">
                <div class="panel-heading">Create Pixels</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'storePixel','class'=>'ajax-form','method'=>'POST']) !!}
                        <div class="form-body">

                        <div class="row">
                                <div class="col-md-12">
                                
                            <div class="row" style="margin-left:15px;" id="questionDiv">
                                <div class="col-md-12">
                                <div class="form-group" >
                                <button type="button" class="btn btn-default btn-sm" onClick="addMoreQuestinos(); return false;">
                                        <span class="glyphicon glyphicon-plus-sign"></span> Add
                                    </button>
                                    
                                    <div class = "addQuestionDiv" style="margin-top:10px;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-3">
                                                    <label>Pixel Name</label>
                                                    <div class="input-icon">
                                                        <input type="text" name="pixelName[]" style="width:95%;">
                                                    </div>
                                                </div>

                                                <div class="col-md-7">
                                                    <label>Pixel code</label>
                                                    <div class="input-icon">
                                                        <textarea name="pixleCode[]" rows="3" cols="80"></textarea>
                                                    </div>
                                                </div>

                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                    </div>

                                    <div class="form-actions" style="margin-top: 70px; margin-left:20px;">
                                        <div class="row">
                                            <div class="col-md-4">
                                            <input type="hidden" name="isQuestionRequired" id="isQuestionRequired" value="0">
                                            <input type="hidden" name="combinedQuestions" id="combinedQuestions">
                                                <button type="button" id="save-form" class="btn btn-success" onClick="validateForm(); return false;"> <i class="fa fa-check"></i> @lang('app.save')</button>
                                            </div>

                                            <div class="col-md-4 alert alert-danger" style=" display:none;  margin-left:10px;" id="errorMessage"></div>

                                        </div>
                                    </div>

                                </div>
                            </div>

</div>
{!! Form::close() !!}
</div>
</div>
</div>
</div>
</div>
</div>
</div>
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
function addMoreQuestinos()
{
    var wrapper         = $(".addQuestionDiv"); //Fields wrapper
    $(wrapper).append('<div class="row"><div class="col-md-12"><div class="col-md-3"><label>Pixel Name</label><div class="input-icon"><input type="text" name="pixelName[]" style="width:95%;"></div></div><div class="col-md-7"><label>Pixel code</label><div class="input-icon"><textarea name="pixleCode[]" rows="3" cols="80"></textarea>&nbsp;&nbsp;<span class="glyphicon glyphicon-minus-sign remove_field" style="cursor:pointer;"></span></div></div></div></div></div>');

}
$(".addQuestionDiv").on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).closest('.row').remove(); 
})

function validateForm()
{
    var isSubmit = true;
    $("#errorMessage").hide();
    $("#errorMessage").html('');


    $("input[name='pixelName[]']").each(function() {
            if ($(this).val() == "") {
                $("#errorMessage").show();
                $("#errorMessage").html('Pixel name should not be blank');
                isSubmit = false;
            }
            else{
                var re = /^[ A-Za-z0-9_@./?&+-]*$/
                if (!re.test($(this).val())) {
                    $("#errorMessage").show();
                    $("#errorMessage").html('Not allow special characters');
                    isSubmit = false;
                }
            }

     });

      $("input[name='pixleCode[]']").each(function() {
            if ($(this).val() == "") {
                $("#errorMessage").show();
                $("#errorMessage").html('Pixel code should not be blank');
                isSubmit = false;
            }
      });

if(isSubmit)
{
    $.easyAjax({
            url: '{{route('admin.savepixel')}}',
            container: '#storePixel',
            type: "POST",
            data: $('#storePixel').serialize(),
            file:  true,
            success: function (response) {
                if (response.status == 'success') {
                  
                    var url = '{{ route('admin.pixel')}}';
                     location.href = url;
                     
                }else{
                    // console.log(response);
                    $("#errorMessage").show();
                    $("#errorMessage").html(response.message);
                }
            }
        });
}
}
</script>
<style type="text/css">
.smallfont{
    font-size:9px;
}
</style>

@endpush