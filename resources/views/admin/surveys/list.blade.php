@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('survey-admin/css/all.min.css') }}">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('survey-admin/css/custom-style.css') }}">
<link rel="stylesheet" href="{{ asset('survey-admin/css/dataTables.bootstrap4.min.css') }}">
<style type = "text/css">
#dataTable_filter{
    display:none !important;
}
</style>
<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">



		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

					<form class="form-inline">
						<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
							<i class="fa fa-bars"></i>
						</button>
					</form>


					<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown no-arrow">
							<span class="nav-link dropdown-toggle">
								<a href="{{ route('admin.surveyPages.manageSurveys') }}" class="btn btn-outline-success btn-sm" aria-pressed="true" role="button">
									Create Survay
								</a>
							</span>

						</li>

					</ul>

				</nav>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">
				{!! Form::open(['id'=>'assignMessageGroup','class'=>'ajax-form','method'=>'POST']) !!}
					<!-- Page Heading -->
					<h1 class="h3 mb-2 text-gray-800"> </h1>
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"> Survay List </h6>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<?php if(!empty($surveys)){ ?>
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>@lang('app.id')</th>
											<th> Survey Link </th>
											<th> Created By </th>
											<th> Created Date </th>
											<th> Views </th>
											<th> Action </th>

										</tr>
									</thead>

									<tbody>
									@forelse($surveys as $key=>$survey)

									<tr>
											<td>{{ $key+1 }}</td>
											<td>{{ $survey->surveyLink }}</td>
											<td>{{ $survey->name }}</td>
											<td>{{ $survey->created_at }}</td>
											<td>{{ $survey->views }}</td>
											<td>

											<div class="btn-group dropdown m-r-10">
												<button aria-expanded="false" data-toggle="dropdown" class="btn dropdown-toggle waves-effect waves-light" type="button"><i class="ti-more"></i></button>
												<ul role="menu" class="dropdown-menu pull-right">
													<li><a href="#!" onClick="deleteSurvey('{{$survey->id}}')"><i class="icon-settings"></i> Delete Survey</a></li>
													<li><a href="{{ url('admin/surveyPages/show-responces/'.$survey->id) }}"><i class="fa fa-files" aria-hidden="true"></i> Show Responses </a></li>

												</ul>
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
                                            <div class="title m-b-15"><table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
												<thead>
												<tr><td></td>
												</tr>
												</thead>
												<tbody><tr><td>No surveys found</td></tr></tbody>
											</table>
										</div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
									@endforelse

									</tbody>
								</table>
							<?php } else {  ?>
										<div>No surveys found</div>
							<?php } ?>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
				</div> <!-- container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="text-center">
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>
</body>
@endsection
@push('footer-script')
<script src="{{ asset('survey-admin/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('survey-admin/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('survey-admin/js/custom-script.min.js') }}"></script>
<script src="{{ asset('survey-admin/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('survey-admin/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('survey-admin/js/datatables-demo.js') }}"></script>



<script>
	$(document).ready(function($) {
		$(".table-row").click(function() {
			window.document.location = $(this).data("href");
		});
	});

</script>
@endpush


{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="groupModal" role="dialog" aria-labelledby="myModalLabel"
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

<script type="text/javascript">
function deleteSurvey(id)
{
	var url = "{{ route('admin.surveyPages.delete-survey',':id') }}";
        url = url.replace(':id', id);
        var token = "{{ csrf_token() }}";
        $.easyAjax({
            type: 'POST',
            url: url,
            data: {
                '_token': token,
                '_method': 'DELETE'
            },
            success: function(response) {
                if (response.status == "success") {
                    location.reload();
                }
            }
        });
}

function showListings(id)
{
	var url = "{{ route('admin.surveyPages.show-responces',':id') }}";
	//url = url.replace(':id', id);

	window.location.href = url;
    // $('#modelHeading').html('Survey Responses');
    // $.ajaxModal('#groupModal', url);

}
</script>