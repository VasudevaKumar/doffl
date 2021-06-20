@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('survey-admin/css/all.min.css') }}">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('survey-admin/css/custom-style.css') }}">
<link rel="stylesheet" href="{{ asset('survey-admin/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('survey-admin/font-awesome/font-awesome.min.css') }}">



<body id="page-top">

<div id="wrapper" class="survey-body">


		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

		<div id="content"> <!-- Main Content -->
		
	<div class="container-fluid"> <!-- Begin Page Content -->

		<nav>
		<div class="card">
		<div class="nav custom-nav nav-tabs" id="nav-tab" role="tablist" style="display:flex;">
		<a class="nav-item nav-link active mr-3" id="nav-home-tab" data-toggle="tab" href="#nav-builder" role="tab" aria-controls="nav-home" aria-selected="true" onClick="questionClick(); false;"> <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i> </a>
		<a class="nav-item nav-link mr-3" id="nav-profile-tab" data-toggle="tab" href="#nav-design" role="tab" aria-controls="nav-profile" aria-selected="false" onClick="designClick('nav-design'); false;">  <i class="fa fa-tint fa-2x" aria-hidden="true"></i>  </a>
		<a class="nav-item nav-link mr-3" id="nav-contact-tab" data-toggle="tab" href="#nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" onClick="linkClick('nav-link'); false;"><i class="fa fa-link fa-2x" aria-hidden="true"></i> </a>
		<a class="nav-item nav-link mr-3" id="nav-view-tab" data-toggle="tab" href="#nav-view" role="tab" aria-controls="nav-view" aria-selected="false" onClick="previewClick('nav-view'); false;"><i class="fa fa-eye fa-2x" aria-hidden="true"></i>  </a>

		</div>
		</div>
		</nav>

		<div class="tab-content mt-4" id="nav-tabContent">
		<div class="tab-pane fade show active" id="nav-builder" role="tabpanel" aria-labelledby="nav-builder">
		<div class="card shadow mb-5">

		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-secondary"> Add Questions </h6>
		
		</div>
		<div class="card-body">
		<div class="main-formpage"> 
		{!! Form::open(['id'=>'questionForm','class'=>'ajax-form','method'=>'POST']) !!}
		<div id = "mainContent">
		<input type="hidden" name="surveyID" class="surveyIDClass" value="">
		<div class="actualContent" id="topdiv1">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<label><span class="h5 badge badge-custom"><i class="fas fa-check text-white"></i> <span class="numberClass">1</span> </span> Question </label>
		<ul class="navbar-nav ml-auto float-right">
		<li class="nav-item dropdown no-arrow">
		<a class="nav-link dropdown-toggle padding-zero" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400" aria-hidden="true"></i>
		</a>
		<div class="dropdown-menu shadow animated--fade-in" aria-labelledby="userDropdown">

		<a class="dropdown-item" href="#" id="dtopdiv1" onClick="deleteThisDiv(this.id); false;">Delete</a>
		</div>
		</li>
		</ul>
		</div>

		<div class="input-group">
			<input id="ques1" type="text" name="questions[]" class="form-control clsQuestion" placeholder="type question here...">
		</div>
		

		<div class="row" style="margin-top:10px; margin-left:0px;"> 

		<!-- <select type="button" name="questionType[]" class="selectpicker" id="" placeholder="choose question type" data-container="" data-live-search="true" title="Add your Question" data-hide-disabled="true" onChange="selectValue(this.value); false;"> -->
		<select  name="questionType[]" onChange="questionType(this.value, this.id);" id="seCls1" class="questionTypeClass">
		
		<option value="">Select question type..</option>
		<option data-content="<i class='fa fa-tv fa-2x pr-2 text-secondary'></i> Welcome Screen"  value="Welcome Screen">Welcome Screen</option>
		<option data-content="<i class='fa fa-tv fa-2x pr-2 text-warning' aria-hidden='true'></i> Thank you Screen" value="Thank you Screen">Thank you Screen</option>
		<option data-content="<i class='fa fa-check fa-2x pr-2 text-primary' aria-hidden='true'></i> Multiple Choice" value="Multiple Choice">Multiple Choice</option>
		<option data-content="<i class='fa fa fa-phone fa-2x pr-2 text-success' aria-hidden='true'></i>  Phone Number" value="Phone Number">Phone Number</option>
		<option data-content="<i class='fa fa-image fa-2x pr-2 text-danger' aria-hidden='true'></i> Picture Choice" value="Picture Choice">Picture Choice</option>
		<option data-content="<i class='fa fa fa-adjust fa-	2x pr-2 text-warning' aria-hidden='true'></i> Yes/No" value="Yes/No">Yes/No</option>
		<option data-content="<i class='fa fa-envelope fa-2x pr-2 text-info' aria-hidden='true'></i> Email" value="Email">Email</option>
		<option data-content="<i class='fa fa-star fa-2x pr-2 text-success' aria-hidden='true'></i> Rating" value="Rating">Rating</option>
		<option data-content="<i class='fa fa-calendar fa-2x pr-2 text-primary' aria-hidden='true'></i> Date" value="Date">Date</option>
		<option data-content="<i class='fa fa-chevron-circle-down fa-2x pr-2 text-secondary' aria-hidden='true'></i> Dropdown" value="Dropdown">Dropdown</option>
		<option data-content="<i class='fa fa-upload fa-2x pr-2 text-danger' aria-hidden='true'></i> File upload" value="File upload">File upload</option>
		<option data-content="<i class='fas fa-credit-card fa-2x pr-2 text-success' aria-hidden='true'></i> Payment" value="Payment">Payment</option>
		<option data-content="<i class='fa fa-link fa-2x pr-2 text-info' aria-hidden='true'></i> Website" value="Website">Website</option>
		</select>
		
		</div>
		<div class="row" style="margin-top:10px; padding-left:0px; margin-left:0px;"> 
		<div class="input-group">
			<div class="optionClass" style="display:none; width:100%;" id="opCls1">
				<input id="optionsID1" type="text" name="options[]" class="form-control optionInputClass" placeholder="type your options here...">
				<span style="font-size:10px;">Write your options in a semicolon separated ( ex: Option1; Option2 etc.,)</span>
			</div>
		</div>


		<div class="input-group">
			<div class="surveyFileClass" style="display:none; width:100%;" id="surfile1">
				<!--
				<input type="file" name="surveyFiles[]">
				<input type="file" name="surveyFiles[]">
				<input type="file" name="surveyFiles[]">
				<input type="file" name="surveyFiles[]">
				-->
			<div class="col-md-12 col-sm-12 margin-bottom">
			<div class="col-md-12 col-sm-12" style="margin-bottom:5px;">
				<i class="fa fa-plus-circle fa-2x" onClick="addMoreFiles()" title="add more files" style="cursor:pointer;"></i>
			</div>
			</div>
			<form class="form-horizontal">
			<div class="text-box form-group">
				<div class="col-sm-4"><input type="file" class="" name="surveyFiles_1[]" id="imageinput"/></div>
			</div>
			</form>

			</div>
		</div>


		</div> <!-- actual content -->
		</div> <!-- main content -->
		
		{!! Form::close() !!}
		</div>
		</div>
		<div class="card-footer py-3">

		</div>
		</div>
		
		<div id="buttons">
			<div style="float:left">
				<button type="button" class="dropdown-toggle btn btn-success btn-md" onClick="clonedIV();"><i class="fas fa-question-circle fa-1x color-secondary"></i> Add your Question...</button>
			</div>
				<div style="float:left; margin-left:10px;">
					<button type="button" class="dropdown-toggle btn btn-success btn-md" onClick="saveQuestions();"><i class="fas fa fa-save fa-1x color-secondary"></i> Save</button>
				</div>
			<div class="alert alert-danger" role="alert" style="float:left; display:none;  margin-left:10px;" id="messageBox"></div>

		</div>
		</div> 
		</div>
		<!--First Builder panel finish here--->


		<div class="tab-pane fade" id="nav-design" role="tabpanel" aria-labelledby="nav-design">

		<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-secondary"> Custemize Style... </h6>
	
		</div>


		<div class="card-body">
		<div>	
		{!! Form::open(['id'=>'designForm','class'=>'ajax-form','method'=>'POST']) !!}		
		<div class="color-table-custom">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"> 
		<input type="hidden" name="surveyID" class="surveyIDClass" value="">
		</div>

			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"> 
			<div> Font Style </div>
			<div> 
			
			<select class="form-control custom-select" name="fontstyle">
			<option value="" selected> System fonts..... </option>
			<option value="10px"> Font One </option>
			<option value="12px"> Font Two </option>
			<option value="13px"> Font Three </option>
			<option value="14px"> Font Four </option>
			<option value="15px"> Font Five </option>
			</select>
		
			</div>		 
			</div>

			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">			
			<div> Questions Color  </div> 			
			<div class="form-group row">			
			<div class="col-10">			
			<input class="form-control input-size" name="QColor" type="color" value="#563d7c" id="example-color-input">
			</div>
			</div>			
			</div>

			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">			
			<div> Answer Color  </div> 			
			<div class="form-group row">			
			<div class="col-10">			
			<input class="form-control input-size" name="AColor" type="color" value="#01AC1A" id="example-color-input">
			</div>
			</div>			
			</div>

		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

			<div> Button Color  </div> 			
			<div class="form-group row">			
			<div class="col-10">			
			<input class="form-control input-size" name="BColor" type="color" value="#4FA9B3" id="example-color-input">
			</div>
			</div>			
			</div>

		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

			<div> Backgraund Color  </div> 			
			<div class="form-group row">			
			<div class="col-10">			
			<input class="form-control input-size" name="BackColor" type="color" value="#EBEBEB" id="example-color-input">
			</div>
			</div>			
			</div>

		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"> 

			<div> <button type="submit" value="Submit" class="btn btn-primary btn-md" role="button" aria-pressed="true" onClick="saveDesigns();"> Save Changes </button> </div>
			<div> <button type="reset" value="Reset" class="btn btn-secondary btn-md float-right" role="button" aria-pressed="true"> Reset </button> </div>
			</div>

		</div>		
		</div>
		
		
		
		</div>
		{!! Form::close() !!}
		</div><!---Design panel finish here--->
		</div>

		<div class="tab-pane fade" id="nav-link" role="tabpanel" aria-labelledby="nav-link">

		<div class="card shadow mb-4">
		<div class="card-header">
	
		<h6 class="m-0 font-weight-bold text-secondary"> Custemize URL... </h6>
		
		</div>
		<div class="card-body ml-4 mr-4 mt-4 mb-4"> 

		<div class="card shadow pl-4 pr-4 pt-4 pb-4">
		<div class="card-body">
		<div>
		{!! Form::open(['id'=>'navLink','class'=>'ajax-form','method'=>'POST']) !!}	
			<label class="pb-3" for="basic-url"><i class="fa fa-link fa-2x" aria-hidden="true"></i> <span class="pl-3"> Add Your URL TAG</span> </label>
			<div class="input-group mb-3">
			<input type="hidden" name="surveyID" class="surveyIDClass" value="">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Ex:ProductA<span>
				</div>
			<input type="text" name="basicUrl" class="form-control" id="basicUrl" aria-describedby="basic-addon3">
			</div>
		<div class="py-3 d-flex flex-row align-items-center justify-content-between"> 

			<div class="float-right"> <button type="submit" value="Submit" class="btn btn-primary btn-md" role="button" aria-pressed="true" onClick="saveUrl();"> Save Changes </button> </div>
			<div class="alert alert-danger" role="alert" style="float:left; display:none;  margin-left:10px;" id="nav-link-messageBox"></div>

		</div>
		{!! Form::close() !!}
		</div>
		</div>
		</div>

		</div>
		</div>			
		</div> <!--URL panel finish here--->

		<div class="tab-pane fade" id="nav-view" role="tabpanel" aria-labelledby="nav-view">

		<div class="card shadow"> 
		<div class="card-header"> 
		<h6 class="m-0 font-weight-bold text-secondary"> Preview </h6>
		</div>
		<div class="card-body m4"> 

		<div class="card shadow-sm p4"> 
		<div class="m-5 p4" id="surveyPriview">
		
		
		</div>
		</div>		
		</div>
		<div class="card-footer"> </div>
		</div>
		</div>


		</div> <!--container-fluid --->

		</div>
		<!-- End of Main Content -->

		<!-- Footer -->
		<footer class="sticky-footer bg-white">
		<div class="container my-auto"><div class="text-center">
		
		<div class="alert alert-danger" role="alert" style="float:left; display:none;  margin-left:10px;" id="globalMessageBox">
			<h4>Please add your questions first.....</h4>
		</div>

		<div class="alert alert-danger" role="alert" style="float:left; display:none;  margin-left:10px;" id="firstQuestionMessageBox">
			<h4>First question should not be deleted......</h4>
		</div>


		</div></div>
		</footer>
		<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

		</div>
		<!-- End of Page Wrapper -->

		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
		</a>
		</body>
		@endsection
		<script src="{{ asset('survey-admin/js/jquery.min.js') }}"></script>
		<script src="{{ asset('survey-admin/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('survey-admin/js/jquery.easing.min.js') }}"></script>
		<script src="{{ asset('survey-admin/js/custom-script.min.js') }}"></script>
		<script src="{{ asset('survey-admin/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('survey-admin/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('survey-admin/js/datatables-demo.js') }}"></script>

		<script type="text/javascript">
		/*
		$('.add-box').click(function(){
				var n = $('.text-box').length + 1;
				if(n > 5)
				{
					alert('Only 5 Savy :D');
					return false;
				}
				var box_html = $('<div class="text-box form-group"><div class="col-sm-4"><input type="file" class="" name="txtImage[]" id="imageinput'+ n +'"/></div><div class="col-sm-2"><button type="submit" class="remove-box btn btn-danger btn-sm"><i class="fa fa-minus-circle fa-lg"></i></button></div></div>');
				$('.text-box:last').after(box_html);
				box_html.fadeIn('slow');
			});

			$('.form-horizontal').on('click', '.remove-box', function(){
					$(this).closest(".form-group").remove();
				return false;
			});
		*/

		function clonedIV(type='add')
		{
		//	$("#mainContent").append($(".actualContent:last").clone());
		$("#messageBox").html('');
		$("#messageBox").hide();
		

		console.log('1'+isValid);

				var idx = +$('.actualContent').length;
				var overAllFlag = true;
				var overAllOptionsFlag = true;
				var overAllFilesFlag = true;
				var overAllOptionMsg = '';
				var overAllFilesMsg = '';


			for(i=1; i<=idx; i++)
			{
				var isValid = true;
				var options = false;
				var fileOptions = false;
				var questionID = 'ques'+i;
				var questionTypeID = 'seCls'+i;
				var topDivID = 'topdiv'+i;
				var optionDivID = 'optionsID'+i;
				var fileTypeID = 'surfile'+i;

				
				
				if(isValid)
				{
					$("#"+topDivID).find("#"+questionID).each(function() {
						// alert(topDivID);
						//alert($(this).val());
						if ($(this).val() == "" ) {
							isValid = false;
							console.log('2'+isValid);
							$("#messageBox").show();
							$("#messageBox").html('Question'+i+' should not be blank');
							overAllFlag = false;
							return false;
						
						}
					});
				}
				
				if(isValid)
				{
					$("#"+topDivID).find("#"+questionTypeID).each(function() {
						// alert(topDivID);
						if ($(this).val() == "" ) {
							isValid = false;
							console.log('3'+isValid);
							$("#messageBox").show();
							$("#messageBox").html('Question'+i+' type should not be blank');
							overAllFlag = false;
							return false;
						}
						
						if($(this).val() == 'Multiple Choice' || $(this).val() =="Dropdown")
						{
							options = true;
						}
						if($(this).val() == 'Picture Choice')
						{
							fileOptions = true;
						}
					});
				

				if(options == true)
				{
					$("#"+topDivID).find("#"+optionDivID).each(function() {
					if ($(this).val() == "" ) {
						isValid = false;
						console.log('4'+isValid);
						// $("#messageBox").show();
						// $("#messageBox").html('Question'+i+' Options should not be blank');
						overAllOptionMsg = 'Question'+i+' Options should not be blank';
						overAllFlag = false;
						overAllOptionsFlag = false;
						return false;
					}
				});
				}

				if(fileOptions == true)
				{
					
						$("#"+topDivID).find("#"+fileTypeID).find("input[name*='surveyFiles']").each(function() {
							$("#messageBox").html('');
							$("#messageBox").hide();
							console.log('pppp');
							console.log($(this).val());
							console.log('isValid - f'+ isValid)
							if ($(this).val() == "" ) {
								isValid = false;
								console.log('5'+isValid);
								// $("#messageBox").show();
								// $("#messageBox").html('Please upload all the files of Question'+i);
								overAllFilesMsg = 'Please upload all the files of Question'+i;
								overAllFlag = false;
								overAllFilesFlag = false;
								return false;
							}
						});
				}
				
			}
			


			} // for 
			
			
			if(!overAllFilesFlag)
			{
				$("#messageBox").show();
				$("#messageBox").html(overAllFilesMsg);
			}

			if(!overAllOptionsFlag)
			{
				$("#messageBox").show();
				$("#messageBox").html(overAllOptionMsg);
			}

			

			if(overAllFlag)
			{
					// alert('fw');
					if(type == 'save')
					{
						return overAllFlag;
					}
					// Update the last <div class=""></div>
					var idx = ++$('.actualContent').length; // check for length and increment it with ++
					var cont = $("#mainContent"),
						div = cont.find(".actualContent").eq(0).clone();
						div.prop('id', 'topdiv'+idx );

					div.find('span.numberClass').text(idx); // <------here you have to put the count
					div.find('input.clsQuestion').val('');

					div.find('div.optionClass').prop('id', 'opCls'+idx );
					div.find('a.dropdown-item').prop('id', 'dtopdiv'+idx );
					div.find('div.surveyFileClass').prop('id', 'surfile'+idx );
					div.find('div.surveyFileClass').hide();
					div.find('div.surveyFileClass').find('.text-box').find('input[type="file"]').val('');
					div.find('div.surveyFileClass').find('.text-box').find('input[type="file"]').prop('name', 'surveyFiles_'+idx+'[]');
					div.find('select.questionTypeClass').prop('id', 'seCls'+idx );
					div.find('input.clsQuestion').prop('id', 'ques'+idx );
					div.find('input.optionInputClass').prop('id', 'optionsID'+idx );
					cont.append(div);
			}

			return overAllFlag;
		}

		function saveQuestions()
		{
			let isValid = true;
			isValid = clonedIV('save');

			if(isValid)
			{
				$.easyAjax({
						url: '{{route('admin.surveyPages.saveQuestion')}}',
						container: '#questionForm',
						type: "POST",
						data: $('#questionForm').serialize(),
						file:  true,
						success: function (response) {
							if (response.status == 'success') {
								// alert('here');
								// console.log(response.data.surveyID);
								$(".surveyIDClass").val(response.data.surveyID);
								$("#nav-builder").hide()
								$("#nav-design").show();
							}
						}
					})
			}

		}

		function saveDesigns()
		{
			$.easyAjax({
						url: '{{route('admin.surveyPages.saveDesigns')}}',
						container: '#designForm',
						type: "POST",
						data: $('#designForm').serialize(),
						file:  true,
						success: function (response) {
							if (response.status == 'success') {
								// alert('here');
							//	console.log(response.data.surveyID);
								// surveyIDClass
								$(".surveyIDClass").val(response.data.surveyID);
							}
						}
					});
		}
		function saveUrl()
		{
			$("#nav-link-messageBox").hide();
			$("#nav-link-messageBox").html('');
			var isValid = true;
			if($("#basicUrl").val() == '')
			{
				$("#nav-link-messageBox").show();
				$("#nav-link-messageBox").html('URL should not be blank.');
				isValid = false;

			}

			if(isValid)
			{
				$("#nav-link-messageBox").hide();
				$("#nav-link-messageBox").html('');

				$.easyAjax({
						url: '{{route('admin.surveyPages.saveURL')}}',
						container: '#navLink',
						type: "POST",
						data: $('#navLink').serialize(),
						file:  true,
						success: function (response) {
							if (response.status == 'success') {
								// alert('here');
								console.log(response.data.surveyID);
								// surveyIDClass
								$(".surveyIDClass").val(response.data.surveyID);
								$("#surveyPriview").html('<a href="'+response.data.surveyLink+'" target="_blank">'+response.data.surveyLink+'</a>')
							}else{
								// console.log(response);
								$("#nav-link-messageBox").show();
								$("#nav-link-messageBox").html(response.message);
							}
						}
					});
			}
		}
		function selectValue(value)
		{
			// alert(value);
		}

		function questionType(value , id)
		{
			// alert(value);
			// alert(id);
			var $div = $('select[id^="seCls"]:last');
			var num = parseInt( $div.prop("id").match(/\d+/g), 10 );
			$("#opCls"+num).hide();
			$("#surfile"+num).hide();

			if(value == 'Multiple Choice' || value=="Dropdown")
			{
				$("#opCls"+num).show();
			}

			if(value == 'Picture Choice')
			{
				$("#surfile"+num).show();
			}
		}

		function addMoreFiles()
		{
			// alert('here');
			var cdx = $('.actualContent').length;
			var idx = +$('.actualContent').length;
				var fileTypeID = 'surfile'+idx;

			var n = $("#"+fileTypeID).find('.text-box').length + 1;
				if(n > 5)
				{
					alert('Only 5 files are allowed');
					return false;
				}
				var box_html = $('<div class="col-md-12 col-sm-12 text-box form-group"><div class="col-sm-4" style="margin:5px 0px 0px 0px; padding:0px;"><input type="file" class="" name="surveyFiles_'+cdx+'[]" id="imageinput'+ n +'"/></div><div class="col-sm-2"><i class="fa fa-minus-circle fa-2x" style="cursor:pointer;" onClick="removeFile(\'imageinput'+n+'\'); false;" title="remove file"></i></div></div>');
				$("#"+fileTypeID).find('.text-box:last').after(box_html);
				box_html.fadeIn('slow');
		}
		
		function removeFile(imageID)
		{
			var idx = +$('.actualContent').length;
				var fileTypeID = 'surfile'+idx;
			// alert(imageID);

				$("#"+fileTypeID).find("#"+imageID).closest(".form-group").remove();
		}

		function questionClick()
		{
				//alert($(".surveyIDClass").val());
				$("#globalMessageBox").hide();
		
		}
		function linkClick(divID)
		{
				// alert(divID);
				$("#nav-design").hide();
				$("#globalMessageBox").hide();

				if($(".surveyIDClass").val()=='')
				{
					$("#globalMessageBox").show();
					$("#"+divID).hide();
					$("#nav-builder").show();
					$("#"+divID).removeClass("tab-pane fade show active in");
					$("#nav-builder").addClass("tab-pane fade show active in");

				}
		
		}
		
		function designClick(divID)
		{
			// alert(divID);
			$("#globalMessageBox").hide();

				if($(".surveyIDClass").val()=='')
				{
					$("#globalMessageBox").show();
					$("#"+divID).hide();
					$("#nav-builder").show();
					$("#"+divID).removeClass("tab-pane fade show active in");
					$("#nav-builder").addClass("tab-pane fade show active in");
				}
		
		}
		function previewClick(divID)
		{
			$("#globalMessageBox").hide();

			if($(".surveyIDClass").val()=='')
			{
				$("#globalMessageBox").show();
					$("#"+divID).hide();
					$("#nav-builder").show();
					$("#"+divID).removeClass("tab-pane fade show active in");
					$("#nav-builder").addClass("tab-pane fade show active in");
			}
		
		}

		function deleteThisDiv(divID)
		{
			let actualDivID = divID.replace('d','');
			$("#firstQuestionMessageBox").hide();
			if(divID == 'dtopdiv1')
			{
				$("#firstQuestionMessageBox").show();
			}
			else{
				$("#"+actualDivID).remove();
			}
		}
		</script>