@extends('layouts.front-app')
@section('content')
    <section class="section bg-img" id="section-contact" style="background-image: url({{ asset('front/img/bg-cup.jpg') }})" data-overlay="8">
        <div class="container">
            <div class="row gap-y">

                <div class="col-12 col-md-8 offset-md-3 form-section">

                 {!! Form::open(['id'=>'register','class'=>'row', 'method'=>'POST']) !!}
                        <div class="col-12 col-md-10 bg-white px-30 py-45 rounded">
                            <h2 class="text-center m-b-15">Thank you</h2>
                            <p id="alert"></p>
                            <div id="form-box">
                                
                                <div class="row">
                                <div id="alert" class="col-lg-12 col-12"><div class="alert alert-success">Thank you for signing up. Please login to get started <a href="http://localhost/doffl/public/login">Login Now</a>.</div></div>
                                
                            </div>
                             


                            

                            </div>

                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer-script')
  
@endpush

<script type="text/javascript">
    function footerAlign() {
        alert('footer') ;
  $('footer').css('display', 'block');
  $('footer').css('height', 'auto');
  var footerHeight = $('footer').outerHeight();
  $('body').css('padding-bottom', footerHeight);
  $('footer').css('height', footerHeight);
}


$(document).ready(function(){
  footerAlign();
});

$( window ).resize(function() {
  footerAlign();
});
</script>