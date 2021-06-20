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
            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('app.create') @lang('app.timeLog') @lang('app.invoice')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'storeJobs','class'=>'ajax-form','method'=>'POST']) !!}
                        <div class="form-body">

                        <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group" >
                                        <label class="control-label">@lang('modules.client.companyName')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                            <select class="selectpicker" data-width="fit" name="company_name" id="company_name">
                                                        <option value="">Please choose</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group" >
                                        <label class="control-label">@lang('app.menu.recruit.jobTitle')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                                    <input type="text" class="form-control" name="job_title" id="job_title" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                            <div class="row">
                             

                             <div class="col-md-4">

                                 <div class="form-group" >
                                     <label class="control-label">@lang('app.menu.recruit.jobType')</label>
                                     <div class="row">
                                         <div class="col-md-12">
                                         <div class="input-icon">
                                                 <input type="text" class="form-control" name="jobType" id="jobType" value="">
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                             </div>
                         </div>

                         <div class="row">
                          

                             <div class="col-md-4">

                                 <div class="form-group" >
                                     <label class="control-label">@lang('app.menu.recruit.salary')</label>
                                     <div class="row">
                                         
                                         <div class="col-md-6">
                                         <div class="input-icon">
                                                 <input type="text" class="form-control" name="minSalary" id="minSalary" value="">
                                                 <span class="smallfont">Min.Salary</span>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                         <div class="input-icon">
                                                
                                                 <input type="text" class="form-control" name="maxSalary" id="maxSalary" value="">
                                                 <span class="smallfont">Max.Salary</span>
                                             </div>
                                         </div>


                                     </div>
                                 </div>

                             </div>
                         </div>
                         

                      <div class="row">
                          

                          <div class="col-md-4">

                              <div class="form-group" >
                                  <label class="control-label">@lang('app.menu.recruit.industry')</label>
                                  <div class="row">
                                      <div class="col-md-12">
                                      <div class="input-icon">
                                              <input type="text" class="form-control" name="industry" id="industry" value="">
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-4">

                              <div class="form-group" >
                                  <label class="control-label">@lang('app.menu.recruit.Workfromhome')</label>
                                  <div class="row">
                                      <div class="col-md-12">
                                      <div class="input-icon">
                                              <select name="workFromHome" id="workFromHome">
                                                 <option value="">Plesae choose</option>
                                                 <option value="1">Yes</option>
                                                 <option value="0">No</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-4">

                              <div class="form-group" >
                                  <label class="control-label">Is required to upload resume ?</label>
                                  <div class="row">
                                      <div class="col-md-12">
                                      <div class="input-icon">
                                              <select name="resumeRequired" id="resumeRequired">
                                                 <option value="">Plesae choose</option>
                                                 <option value="1">Yes</option>
                                                 <option value="0">No</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                    
                      <div class="row">
                          <div class="col-md-4">

                              <div class="form-group" >
                                  <label class="control-label">Is required to upload additional documents ?</label>
                                  <div class="row">
                                      <div class="col-md-12">
                                      <div class="input-icon">
                                              <select name="additionalDocs" id="additionalDocs">
                                                 <option value="">Plesae choose</option>
                                                 <option value="1">Yes</option>
                                                 <option value="0">No</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-4">

                              <div class="form-group" >
                                  <label class="control-label">Is required to additional links ( ex: LinkedIn) ?</label>
                                  <div class="row">
                                      <div class="col-md-12">
                                      <div class="input-icon">
                                              <select name="additionalLinks" id="additionalLinks">
                                                 <option value="">Plesae choose</option>
                                                 <option value="1">Yes</option>
                                                 <option value="0">No</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>

                            <div class="row">
                                <div class="col-md-8">

                                    <div class="form-group" >
                                        <label class="control-label">@lang('app.menu.recruit.jobdescription')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                            <textarea class="textarea_editor form-control" rows="10" name="job_description"
                                                  id="job_description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                             
                            </div>
                            
                            <div class="row">
                             

                                <div class="col-md-8">

                                    <div class="form-group" >
                                        <label class="control-label">@lang('app.menu.recruit.jobResponsibilities')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                            <textarea class="textarea_editor form-control" rows="10" name="job_Responsibilities"
                                                  id="job_Responsibilities"></textarea>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                             

                                <div class="col-md-8">

                                    <div class="form-group" >
                                        <label class="control-label">@lang('app.menu.recruit.jobBenefits')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                            <textarea class="textarea_editor form-control" rows="10" name="job_Benefits"
                                                  id="job_Benefits"></textarea>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                             

                                <div class="col-md-8">

                                    <div class="form-group" >
                                        <label class="control-label">Terms & Conditions</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                            <textarea class="textarea_editor form-control" rows="10" name="terms"
                                                  id="terms"></textarea>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>


                            <div class="row" style="margin-left:15px;">
                                <div class="col-md-8">
                                <div class="form-group" >
                                        <label class="control-label">Do you want to add questions ?</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                                <input type="checkbox" data-toggle="toggle" id="questionToggle">
                                             </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row" style="margin-left:15px; display:none;" id="questionDiv">
                                <div class="col-md-8">
                                <div class="form-group" >
                                <button type="button" class="btn btn-default btn-sm" onClick="addMoreQuestinos(); return false;">
                                        <span class="glyphicon glyphicon-plus-sign"></span> Add
                                    </button>
                                    
                                    <div class = "addQuestionDiv" style="margin-top:10px;">
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                                <input type="text" name="questions[]" style="width:95%;">
                                             </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <hr>

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
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

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
$('#job_description').wysihtml5();
$('#job_Responsibilities').wysihtml5();
$("#job_Benefits").wysihtml5();
$("#terms").wysihtml5();

function validateForm()
{
    var isSubmit = true;
    $("#errorMessage").html('');
    $("#errorMessage").hide();
    
    if($("#company_name").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Company name should not be empty');
        isSubmit = false;
    }

    if($("#job_title").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Job title should not be empty');
        isSubmit = false;
    }

    if($("#jobType").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Job type should not be empty');
        isSubmit = false;
    }

    if($("#minSalary").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Mininum salary should not be empty');
        isSubmit = false;
    }

    if($("#minSalary").val() != '')
    {
        var regex = /^[0-9\s]*$/;
        if(!regex.test ($("#minSalary").val()))
        {
            $("#errorMessage").show();
            $("#errorMessage").html('Mininum salary allow only numbers');
            isSubmit = false;
        }
    }


    if($("#maxSalary").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Maximum salary should not be empty');
        isSubmit = false;
    }

    if($("#maxSalary").val() != '')
    {
        var regex = /^[0-9\s]*$/;
        if(!regex.test ($("#maxSalary").val()))
        {
            $("#errorMessage").show();
            $("#errorMessage").html('Maximum salary allow only numbers');
            isSubmit = false;
        }
    }

    if( $("#minSalary").val()!='' && $("#maxSalary").val() != '')
    {
        var maxSlary = parseInt($("#maxSalary").val());
        var minSalary = parseInt($("#minSalary").val());

        if(minSalary >maxSlary)
        {
      
            $("#errorMessage").show();
            $("#errorMessage").html('Maximum salary should not be less than the minimum salary');
            isSubmit = false;
        }
    }

    if($("#industry").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Industry should not be empty');
        isSubmit = false;
    }

    if($("#workFromHome").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Work from home should not be empty');
        isSubmit = false;
    }

    if($("#job_description").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Job description should not be empty');
        isSubmit = false;
    }

    if($("#job_Responsibilities").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Job responsibilities should not be empty');
        isSubmit = false;
    }

    if($("#job_Benefits").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Job benefits should not be empty');
        isSubmit = false;
    }

    if($("#resumeRequired").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Choose resume is required or not?');
        isSubmit = false;
    }

    if($("#additionalDocs").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Choose additioal documents are required or not?');
        isSubmit = false;
    }

    if($("#additionalLinks").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Choose additioal links are required or not?');
        isSubmit = false;
    }

    if($("#isQuestionRequired").val() == 1)
    {
        let combinedQuestionStr = '';

        $("input[name='questions[]']").each(function() {
            if ($(this).val() == "") {
                $("#errorMessage").show();
                $("#errorMessage").html('Question should not be blank');
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

            combinedQuestionStr += $(this).val()+'###';



      });

     // console.log(combinedQuestions);
      if(combinedQuestionStr!='')
      {
          $("#combinedQuestions").val(combinedQuestionStr);
      }
    }


    if(isSubmit)
    {
       //alert('added');
       $("#errorMessage").html('');
        $("#errorMessage").hide();

       $.easyAjax({
            url: '{{route('admin.recruit.saveJob')}}',
            container: '#storeJobs',
            type: "POST",
            data: $('#storeJobs').serialize(),
            file:  true,
            success: function (response) {
                if (response.status == 'success') {
                  
                    var url = '{{ route('admin.recruit.managejob')}}';
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

$('#questionToggle').on('change.bootstrapSwitch', function(e) {
    // console.log(e.target.checked);
    if(e.target.checked)
    {
        $("#isQuestionRequired").val(1);
        $("#questionDiv").show();
    }
    else{
        $("#isQuestionRequired").val(0);
        $("#questionDiv").hide();
    }

});


$('#questionToggle').bootstrapToggle({
      on: 'Yes',
      off: 'No'
    });


function addMoreQuestinos()
{
    var wrapper         = $(".addQuestionDiv"); //Fields wrapper
    $(wrapper).append('<div class="row" style="margin-top:5px;"><div class="col-md-12"><div class="input-icon"><input type="text" name="questions[]" style="width:95%;">&nbsp;&nbsp;<span class="glyphicon glyphicon-minus-sign remove_field" style="cursor:pointer;"></span></div></div></div>');

}

$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); 
})

</script>


@endpush

<style type="text/css">
.smallfont{
    font-size:9px;
}
</style>