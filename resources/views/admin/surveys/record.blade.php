@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('survey-admin/css/all.min.css') }}">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('survey-admin/css/custom-style.css') }}">
<link rel="stylesheet" href="{{ asset('survey-admin/css/dataTables.bootstrap4.min.css') }}">

<body id="page-top">

<div id="wrapper">

			

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<form class="form-inline">
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
<i class="fa fa-bars"></i>
</button>
</form>


<ul class="navbar-nav ml-auto"> 
<li class="nav-item dropdown no-arrow"> 
<span class="nav-link dropdown-toggle">
<a href="#" class="btn btn-outline-success btn-sm" aria-pressed="true" role="button">         
Create Survay
</a>
</span>

</li>

<li class="nav-item"> 
<span class="nav-link">

<button class="btn btn-primary btn-sm dropdown-toggle" href="#" id="userDropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-download"> </i> Export  </button>

<div style="margin-top: -10px;" class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

<a class="dropdown-item" href="#">
CSV
</a>

<a class="dropdown-item" href="#">  
 PDF
</a>
<a class="dropdown-item" href="#">
 Excel
</a>
</div>		

</span>

</li>
</ul>

</nav>
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"> </h1>
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary"> Survey Response </h6>
</div>

<div class="card-body m-4">

<!-- Content Row -->
<div class="row">

<!-- Content Column -->
<div class="col-lg-6 mb-4">

<!-- Table  -->
<table class="table fixed_header table-condensed table-striped table-hover">
<!-- Table head -->
<thead>
<tr>
<th>
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" id="tableDefaultCheck1">
<label class="custom-control-label" for="tableDefaultCheck1"> 2 Response in Total </label>
</div>
</th>
</tr>
</thead>
<!-- Table head -->

<!-- Table body -->
<tbody>
<tr class="table-row" data-href="#">
<th scope="row">
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" id="tableDefaultCheck2">
<label class="custom-control-label" for="tableDefaultCheck2">14 july</label>
</div>
</th>
<td> exampletome@yahoomail.com </td>
</tr>
<tr class="table-tr-margin table-row">
<th scope="row">
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" id="tableDefaultCheck3">
<label class="custom-control-label" for="tableDefaultCheck3">07 july</label>
</div>
</th>
<td>aaaexa@gmail.com</td>
</tr>
</tbody>
<!-- Table body -->
</table>


<!-- Table  -->
</div>

 <div class="col-lg-6 mb-4">

<div class="card shadow-sm mb-4">
<div class="card-body mb-5 p-0"> 
<div class="card-header mb-4 py-3 d-flex flex-row align-items-center justify-content-between"> 

<div> <span class="bolder"> July 16, 2020  <span class="small ml-2"> 05:30 PM </span> </span>  </div>
<div class="float-right"> 
<a href="#"> <i class="fa fa-print pr-4" aria-hidden="true"></i> </a>  <a href="#"> <i class="fa fa-trash" aria-hidden="true"></i> </a> </div>
</div>
    

<img class="card-img-top" src="/doffl/public/survey-admin/img/undraw_posting_photo.svg" alt="Card image cap">
</div>
</div>

</div> <!-- Column End -->

</div> <!-- Row End -->



</div>
</div>

</div> <!--container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
<div class="container my-auto">
<div class="text-center">
<span> </span>
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