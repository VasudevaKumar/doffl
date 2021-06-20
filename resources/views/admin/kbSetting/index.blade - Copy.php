@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('kbSettings/css/all.min.css') }}">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('kbSettings/css/custom-style.css') }}">
<link rel="stylesheet" href="{{ asset('kbSettings/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('survey-admin/font-awesome/font-awesome.min.css') }}">
@endsection
<body id="page-top">

		<!-- Page Wrapper -->
		<div id="wrapper" class="survey-body">

		<ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="accordionSidebar">
		<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
		<div class="sidebar-brand-text mx-3"> KB Admin </div>
		</a>
		<hr class="sidebar-divider my-0">
		<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
		<i class="fas fa-fw fa-cog"></i>
		<span> Categories </span>
		</a>
		</li>
		
		<li class="nav-item active">
		<a class="nav-link" href="kb-site-setting.html">
		<i class="fa fa-cog" aria-hidden="true"></i>
		<span> Site Settings </span></a>
		</li>
		
		<li class="nav-item">
		<a class="nav-link" href="kb-categories.html">
		<i class="fa fa-list-ul" aria-hidden="true"></i>
		<span>Categories </span></a>
		</li>
		
		<!---<li class="nav-item">
		<a class="nav-link" href="admin-survay-record.html">
		<i class="fas fa-fw fa-pencil-square-o"></i>
		<span>Admin Survay Record </span></a>
		</li>--->

		<!-- Divider -->
		<hr class="sidebar-divider d-none d-md-block">

		<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
		</div>
		</ul>

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

		<div id="content" style="margin-left:250px;"> <!-- Main Content -->
		
		<!-- Nav Top Bar Start -->
		<nav class="navbar navbar-expand navbar-light bg-custom-color topbar mb-5 static-top shadow">	
		
		<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
		<i class="fa fa-bars"></i>
		</button>
		
		
		<div> <h4> Site Settings </h4> </div>
		
		<ul class="navbar-nav ml-auto">
			<?php 
			if(!empty($companies))
			{ ?>
				<div style="margin-right: 5px;">Company has already configured site settings.</div>
				<a href="#" onclick="shareUrl({{ $companies[0]->id }}); false;">See here</a>
			<?php }
			?>
		</ul>
		</nav>

		<div class="container-fluid"> <!-- Begin Page Content -->

		<nav>
		<div class="card">
		<div class="nav custom-nav nav-tabs" id="nav-tab" role="tablist" style="display:flex;">
		<a class="nav-item nav-link active mr-0" id="nav-home-tab" data-toggle="tab" href="#nav-builder" role="tab" aria-controls="nav-home" aria-selected="true" onClick="generalSectionClick(); false;"> <i class="fa fa-home" aria-hidden="true"></i> General </a>
		<a class="nav-item nav-link mr-0" id="nav-profile-tab" data-toggle="tab" href="#nav-design" role="tab" aria-controls="nav-profile" aria-selected="false" onClick="themeSectionClick('nav-design'); false;">  <i class="fa fa-image" aria-hidden="true"></i>  Logo & Theme  </a>
		<a class="nav-item nav-link mr-0" id="nav-contact-tab" data-toggle="tab" href="#nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" onClick="trackSectionClick('nav-link'); false;"> <i class="fa fa-code" aria-hidden="true"></i> Tracking </a>

		</div>
		</div>
		</nav>

		<div class="tab-content mt-4" id="nav-tabContent">
		<div class="tab-pane fade show active" id="nav-builder" role="tabpanel" aria-labelledby="nav-builder">
		<div class="card shadow-sm mb-5">

		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-secondary"> General Settings </h6>		

		</div>
		<div class="card-body">
		
		<div class="main-formpage">
		
		{!! Form::open(['id'=>'generalSettings','class'=>'ajax-form','method'=>'POST']) !!}	
		<div class="form-group">
        <input type="hidden" name="settingID" class="settingIDClass" value="">
		<label> Company Name </label>
        <br />
		<select class="selectpicker" data-width="fit" name="company_name" id="company_name">
                        <option value="">Please choose</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
		<small id="emailHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
		</div>
		<div class="form-group">
		<label> Site Title * </label>
		<input id="siteTitle" name="siteTitle" type="text" class="form-control" placeholder="site title">
		<small id="emailHelp" class="form-text text-muted">Example: Help Documentation.</small>
		</div>
		
		<div class="form-group">
		<label> Welcome Text * </label>
		<input id="welcomeText" name="welcomeText" type="text" class="form-control" placeholder="Welcome Text">
		<small id="emailHelp" class="form-text text-muted">Example: How we can help you today.</small>
		</div>
		
		<div class="form-group">
		<div class="form-check">
		<input class="form-check-input" type="checkbox" id="gridCheck" name="gridCheck" checked="true">
		<label class="form-check-label" for="gridCheck">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Published?</label>
		<small id="emailHelp" class="form-text text-muted">If you are not ready to got live yet, keep this site unplished. unplished sites are private site, and are only visible to users of your Knowladge Base account</small>
		</div>
		</div>

        <div class="py-3 d-flex flex-row align-items-center justify-content-between"> 

			<div class="float-right"> <button type="submit" value="Submit" class="btn bg-gradient-dark btn-dark color-white btn-md" role="button" aria-pressed="true" onClick="saveGeneral();"> Save Changes </button> </div>
			<div class="alert alert-danger" role="alert" style="float:left; display:none;  margin-left:10px;" id="nav-link-messageBox"></div>

		</div>

		{!! Form::close() !!}

		</div>
		</div>
		<div class="card-footer py-3">

		</div>
		</div>
		  
		</div> <!--First Builder panel finish here--->


		<div class="tab-pane fade" id="nav-design" role="tabpanel" aria-labelledby="nav-design">

		<div class="card shadow-sm mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-secondary"> Style Theme </h6>			
		</div>
		<div class="card-body">
		<div>			
		<div class="">

		<div class="py-3"> 
		<div> 
		{!! Form::open(['id'=>'themeSettings','class'=>'ajax-form','method'=>'POST']) !!}
		<div class="form-group">
        <input type="hidden" name="settingID" class="settingIDClass" value="">
		<label class="hr h4" for="exampleFormControlFile1"> Logo </label>
		

        <div class="row">
                                    <div class="col-md-6" style="margin-top:25px;">
                                       <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                     style="max-width: 300px; max-height: 50px; margin-left:8px !important;"></div>
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


		<small class="pt-3" style="margin-left:10px;"> This logo is also be used as a fevicon, for best results make sure the image is in square dimension - 100 x 100. </small>
		
		</div>
		
		<div class="form-check form-group ml-4">
		<input type="checkbox" class="form-check-input" id="exampleCheck1" checked="true">
		<div> <label class="form-check-label" for="exampleCheck1" style="margin-left:20px;">Show logo in header</label> </div>
		<small style="margin-left:10px;"> if this option is not checked company name will be displayed in header </small>
		</div>
		
		<div class="form-group mt-4">
		<label class="hr h4"> Theme style </label>
		<div class="form-row">
		<div class="col">
		<input class="form-control" type="text" name ="theme1" id="example-color-input" placeholder="#ECDESE">
		<small>EX: #EBEBEB  </small>
		</div>
		<div class="col">
		<input class="form-control" type="text" name ="theme2" id="example-color-input" placeholder="#EBEBEB">
		<small>EX: #EBEBEB  </small>
		</div>
		</div>
		</div>
		

        <div class="py-3 d-flex flex-row align-items-center justify-content-between"> 

			<div class="float-right"> <button type="submit" value="Submit" class="btn bg-gradient-dark btn-dark color-white btn-md" role="button" aria-pressed="true" onClick="saveTheme();"> Save Changes </button> </div>
			<div class="alert alert-danger" role="alert" style="float:left; display:none;  margin-left:10px;" id="nav-design-messageBox"></div>

		</div>


		
		</div>		 
		</div>

		</div>
        {!! Form::close() !!}		
		</div>
		</div>
		</div>
		</div><!---Design panel finish here--->

		<div class="tab-pane fade" id="nav-link" role="tabpanel" aria-labelledby="nav-link">
		{!! Form::open(['id'=>'tracking','class'=>'ajax-form','method'=>'POST']) !!}
		<div class="card shadow-sm mb-4">
		<input type="hidden" name="settingID" class="settingIDClass" value="">
		<div class="card-header">
		<h6 class="m-0 font-weight-bold text-secondary"> Tracking </h6>
		</div>
		<div class="card-body mt-4 mb-0 mr-4 ml-4">
		
		
		<div class="form-group form-inline">
		<label class="h3">Tracking</label>
		<input type="text" name ="googleTracking" id="" class="form-control mx-sm-3" placeholder="UIA-XXXXXX-XXX-X">
		<small class="text-muted">
		Google Analytics Tracking Id
		</small>
		</div>
		<div class="form-row"> <small class="text-muted"> You can track visits to your site by adding <a href="#"> Google Analytics Tracking Id </a> </small> </div>
		
		<div class="form-group mt-4">
		
		<div class="py-3 d-flex flex-row align-items-center justify-content-between"> 

			<div class="float-right"> <button type="submit" value="Submit" class="btn bg-gradient-dark btn-dark color-white btn-md" role="button" aria-pressed="true" onClick="saveTrack();"> Save Changes </button> </div>


		</div>

		</div>
		
		</div>
		</div>

		</div>
		<div class="card-header">
		</div>

		</div>
		{!! Form::close() !!}			
		</div> <!--URL panel finish here--->


				

		</div> <!--container-fluid --->

		</div>
		<!-- End of Main Content -->

		<!-- Footer -->
		<br>
		<footer class="sticky-footer bg-white" style="margin-left:250px; font-size:12px;>
		<div class="container my-auto">
		<div class="text-center">

		<div class="alert alert-danger" role="alert" style="float:left; display:none;  margin-left:10px;" id="globalMessageBox">
			<h4>Please configure general setting first.....</h4>
		</div>


		</div>
		</div>
		</footer>
		<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->


		<div id="myModal" class="modal">

                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <p><div id="dynamicContent">Some text in the Modal..</div></p>
                  </div>

                </div>

		</div>
		<!-- End of Page Wrapper -->

		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
		</a>

		<!-- Bootstrap core JavaScript-->

        <script src="{{ asset('kbSettings/js/jquery.min.js') }}"></script>
        <script src="{{ asset('kbSettings/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('kbSettings/js/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('kbSettings/js/custom-script.min.js') }}"></script>
        <script src="{{ asset('kbSettings/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('kbSettings/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('kbSettings/js/datatables-demo.js') }}"></script>

        <script type="text/javascript">
            function saveGeneral()
            {
                $("#nav-link-messageBox").hide();
                $("#nav-link-messageBox").html('');
                var isValid = true;
                if($("#company_name").val() == '')
                {
                    $("#nav-link-messageBox").show();
                    $("#nav-link-messageBox").html('Company name should not be blank.');
                    isValid = false;

                }

                if($("#siteTitle").val() == '')
                {
                    $("#nav-link-messageBox").show();
                    $("#nav-link-messageBox").html('Site title should not be blank.');
                    isValid = false;
                }

                if($("#welcomeText").val() == '')
                {
                    $("#nav-link-messageBox").show();
                    $("#nav-link-messageBox").html('Welcome text should not be blank.');
                    isValid = false;
                }

                if($("#welcomeText").val() == '')
                {
                    $("#nav-link-messageBox").show();
                    $("#nav-link-messageBox").html('Welcome text should not be blank.');
                    isValid = false;
                }

                if(isValid)
                {
                    $("#nav-link-messageBox").hide();
                    $("#nav-link-messageBox").html('');

                    $.easyAjax({
                            url: '{{route('admin.knowledgebase.saveGeneral')}}',
                            container: '#generalSettings',
                            type: "POST",
                            data: $('#generalSettings').serialize(),
                            file:  true,
                            success: function (response) {
                                if (response.status == 'success') {
                                    // alert('here');
                                    console.log(response.data.settingID);
                                    // surveyIDClass
                                    $(".settingIDClass").val(response.data.settingID);
                                    // $("#surveyPriview").html('<a href="'+response.data.surveyLink+'" target="_blank">'+response.data.surveyLink+'</a>')
                                }else{
                                    // console.log(response);
                                    $("#nav-link-messageBox").show();
                                    $("#nav-link-messageBox").html(response.message);
                                }
                            }
                        });
                }


            }

            function saveTheme()
            {
                var isValid = true;

                if(isValid)
                {
                    $("#nav-link-messageBox").hide();
                    $("#nav-link-messageBox").html('');

                    $.easyAjax({
                            url: '{{route('admin.knowledgebase.saveDesign')}}',
                            container: '#themeSettings',
                            type: "POST",
                            data: $('#themeSettings').serialize(),
                            file: (document.getElementById("image").files.length == 0) ? false : true,
                            success: function (response) {
                                if (response.status == 'success') {
                                    // alert('here');
                                    console.log(response.data.settingID);
                                    // surveyIDClass
                                    $(".settingIDClass").val(response.data.settingID);
                                    // $("#surveyPriview").html('<a href="'+response.data.surveyLink+'" target="_blank">'+response.data.surveyLink+'</a>')
                                }else{
                                    // console.log(response);
                                    $("#nav-link-messageBox").show();
                                    $("#nav-link-messageBox").html(response.message);
                                }
                            }
                        });
                }

            }

			function saveTrack()
			{
				var isValid = true;

                if(isValid)
                {
                    

                    $.easyAjax({
                            url: '{{route('admin.knowledgebase.saveTrack')}}',
                            container: '#tracking',
                            type: "POST",
                            data: $('#tracking').serialize(),
                            file:  true,
                            success: function (response) {
                                if (response.status == 'success') {
                                    // alert('here');
                                    console.log(response.data.settingID);
                                    // surveyIDClass
                                    $(".settingIDClass").val(response.data.settingID);
                                    // $("#surveyPriview").html('<a href="'+response.data.surveyLink+'" target="_blank">'+response.data.surveyLink+'</a>')
                                }
                            }
                        });
                }
			}

			function generalSectionClick()
			{
				$("#globalMessageBox").hide();
			}
			function themeSectionClick(divID)
			{
				$("#globalMessageBox").hide();
				
				$("#nav-design").hide();
				$("#nav-link").hide();

				if($(".settingIDClass").val()=='')
				{
					$("#globalMessageBox").show();
					$("#"+divID).hide();
					$("#nav-builder").show();
					$("#"+divID).removeClass("tab-pane fade show active in");
					$("#nav-builder").addClass("tab-pane fade show active in");
				}
			}
			function trackSectionClick(divID)
			{
				$("#globalMessageBox").hide();

				$("#nav-design").hide();
				$("#nav-link").hide();


				if($(".settingIDClass").val()=='')
				{
					$("#globalMessageBox").show();
					$("#"+divID).hide();
					$("#nav-builder").show();
					$("#"+divID).removeClass("tab-pane fade show active in");
					$("#nav-builder").addClass("tab-pane fade show active in");
				}

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
    var urlString = 'http://'+window.location.hostname+'/support/index.php?companyID='+id;
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
  height: 40%; /* Full height */
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
  width: 35% !important;
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
		

		

		</body>

