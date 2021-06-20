@extends('layouts.member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->

        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        
        
        <!-- <label class="control-label">
            <a href="javascript:;" id="addFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.files.addFiles')</a>
        </label>
        -->



        <label class="control-label">
            <a href="#" onClick="createJob(); return false;" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.Recruit.addJob')</a>
        </label>

            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang("app.menu.home")</a></li>
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

@endpush

@section('content')


<div class="row">
    {!! Form::open(['id'=>'manageJobs','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="col-md-12">
            <div class="white-box">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>Job title</th>
                            <th>Job type</th>
                            <th>Salary</th>
                            <th>Work from home</th>
                            <th>Resume Required</th>
                            <th>@lang('app.createdAt')</th>
                            <th>@lang('app.Views')</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($jobs as $key=>$job)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $job->job_title }}</td>
                                <td>{{ $job->jobType }}</td>
                                <td>{{ $job->minSalary }} - {{ $job->maxSalary }}</td>
                                <td>{{ $job->workFromHome }}</td>
                                <td>{{ $job->resumeRequired }}</td>
                                <td>{{ $job->created_date }}</td>
                                <td>{{ $job->views }}</td>
                                <td><a href="#" onclick="shareUrl({{ $job->id }}); false;">Share</a></td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3 float-left">
                                        <button type="button" class="btn btn-default btn-sm" onClick="editJob({{ $job->id }})">
                                              <span class="glyphicon glyphicon-edit"></span> 
                                        </button>

                                        </div>

                                        <div class="col-md-3 float-left">

                                        <button type="button" class="btn btn-default btn-sm" onClick="deleteJob({{ $job->id }})">
                                              <span class="glyphicon glyphicon-remove-sign"></span> 
                                        </button>

                                        </div>

                                        <div class="col-md-3 float-left">

                                        <button type="button" class="btn btn-default btn-sm" onClick="profileList({{ $job->id }})">
                                              <span class="glyphicon glyphicon-user"></span> 
                                        </button>

                                        </div>



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

<!-- The Modal -->
                <div id="myModal" class="modal">

                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <p><div id="dynamicContent">Some text in the Modal..</div></p>
                  </div>

                </div>

@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>

@endpush

<style type="text/css">
.smallfont{
    font-size:9px;
}
</style>

<script type="text/javascript">
function editJob(id)
{
      var url = '{{ route('member.recruit.editJob', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
}

function createJob()
{
    var url = '{{ route('member.recruit')}}';
       location.href = url;
}

function deleteJob(id)
{
    var  url = '{{route('member.recruit.deleteJob')}}';
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

function manageQuestions(id)
{
        var url = '{{ route('member.recruit.manageQuestions', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
}

function profileList(id)
{
    var url = '{{ route('member.recruit.profilelist', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
}


var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
/*
btn.onclick = function() {
  modal.style.display = "block";
}
*/

function shareUrl(id)
{
    var urlString = 'https://'+window.location.hostname+'/recruit/index.php?jid='+id;
    document.getElementById("dynamicContent").innerHTML = urlString;
    modal.style.display = "block";

}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>

<style type="text/css">
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 35%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
  
</style>