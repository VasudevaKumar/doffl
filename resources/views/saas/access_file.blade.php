<!DOCTYPE html>
		<html lang="en">

		<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title> FIle Download page </title>
		
		<!-- Custom fonts for this template -->
		<link href="/acss/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="/acss/custom-style.css" rel="stylesheet">
		<!-- Custom styles for this page -->
		<link href="/acss/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
		@if($pixels)
    		@foreach($pixels as $pix)
    		    {!! $pix->pixelCode !!}
    		@endforeach
		@endif
		</head>
		
		<body>		
		<div class="bg-light py-3 container-body">
		<div class="container">		
		<div class="row">
		<div class="col-lg-12 auto mt-5">
		<div class="card"> 
		<div class="card-body text-dark"> 
		
		<div class="p-5">
		
		<h3> File Info </h3>
		<table class="table table-striped">
		<thead>
		<tr>
		<th scope="col">#</th>
		<th scope="col">File Name </th>
		<th scope="col">File Size </th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<th scope="row">1</th>
		<td>{{$file->filename}}</td>
		<td>{{$file->filesize != null ? number_format($file->filesize / 1024, 2) . " Kb" : "NA"}}</td>
		</tr>
		
		</tbody>
		</table>
		@if($file->password != null)
		<div class="card-body border bg-light mt-5 p-4 col-sm-12">
		<div class="alert alert-info" role="alert" style="background-color: {{$config->theme_bg}}; color: {{$config->theme_text}};">  <i class="fa fa-info-circle fa-1x pr-3" aria-hidden="true"></i>  Please enter the password to download the files. </div>	
		<div class="d-flex align-items-center justify-content-center">		
		<div class="form-group row">
		<div class="col-sm-8">
		<form class="form-signin" action="{{route('front.check-pword', $token)}}" method="POST">
            @csrf
       
		<input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="pword" placeholder="Enter password"> 
		</div>
		<div class="col-sm-2">
		<button type="submit" class="btn btn-success btn-lg" style="background-color: {{$config->theme_bg}}; color: {{$config->theme_text}};">Submit</button>
		</div>
		
		</div>		
		</form>	
		</div>
		@endif
		@if (session($token) && (Session::get($token) == "failed"))
			<div class="alert alert-danger" role="alert" style="background-color: {{$config->theme_bg}}; color: {{$config->theme_text}};"> Please enter a right Password. </div>
		@endif		
		
		
		@if (session($token) && (Session::get($token) == "success"))
		<div class="py-4 col-sm-12 text-center"> 	
		
			<div class="alert alert-success" role="alert" style="background-color: {{$config->theme_bg}}; color: {{$config->theme_text}};">  <i class="fa fa-check pr-3" aria-hidden="true"></i> Download file by clicking the button below. </div>
		<form class="form-signin" action="{{route('front.download-file', $token)}}" method="POST">
            @csrf
		<button type="submit" class="btn btn-lg mt-4" style="background-color: {{$config->theme_bg}}; color: {{$config->theme_text}};"> <i class="fa fa-download pr-3" aria-hidden="true" ></i> Download Now </button>
		</form>
		</div>
		@endif
		
		
		</div>
		</div>
		
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		
		
		
		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top"> <i class="fas fa-angle-up"></i>  </a>		
		
		<!-- Bootstrap core JavaScript-->
			<script src="/ajs/jquery.min.js"></script>
			<script src="/ajs/bootstrap.bundle.min.js"></script>
		
</body>
</html>