@extends('layouts.member-app')


@section('page-title')

@push('head-script')
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">


<link rel="stylesheet" href="{{ asset('survey-pages/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('survey-pages/css/fsscroller.min.css') }}">
<link rel="stylesheet" href="{{ asset('survey-pages/css/intlTelInput.css') }}">
<link rel="stylesheet" href="{{ asset('survey-pages/css/demo.css') }}">
<link rel="stylesheet" href="{{ asset('survey-pages/css/bootstrap-image-checkbox.css') }}">
<link rel="stylesheet" href="{{ asset('survey-pages/css/font-awesome-animation.min.css') }}">

@endpush


  <!--Navbar-->
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark primary-color">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="#">Fill the Survay Form</a>


  </nav>
  <!--/.Navbar-->


   
    <!-- Collapsible content -->
    
<nav class="navbar fixed-bottom navbar-expand-lg navbar-dark">

   <div class="row">
        <div class="progress" id="progress1">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">                
            </div>
            <span class="progress-type">Overall Progress</span>
            <span class="progress-completed">0%</span>
        </div>      
    </div>

  </nav>

  <div class="full-screen-scroller">
    <div class="fss-dotted-scrollspy">
      <button type="button" class="fss-nav-btn fss-mainview-prev">
        <i class="fa fa-chevron-up"></i>
      </button>
      
      
      
      <button type="button" class="fss-nav-btn fss-mainview-next">
        <i class="fa fa-chevron-down"></i>
      </button>
    </div>
    
     <div fss-anchor="view-1" class="fss-mainview fss-active" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
  
  
<div class="box">
<div class="info">
<div class="welcome-screen"> </div>
<form class="inner-form">
<div class="form-group">
<label style="font-size:24px; text-align:center; text-transform: uppercase;">Start Survey </label>
<div class="p-2">  </div>
<div class="p-2">  </div>
<button style="float:left;" type="button" onclick="javascript: resetActive(event, 0);" class="btn btn-custom-color fss-mainview-next"">Start </button> <span style="font-size: 16px; padding-left: 22px; color: #2257af; font-weight: bold;"> Start </span>
</div> 
</form>
</div>
</div>
      
  </div>
    

    <div fss-anchor="view-2" class="fss-mainview">
      <div class="fss-subview">
        <!--<div class="fss-dotted-scrollspy">
          <button type="button" class="fss-nav-btn fss-subview-prev">
            <i class="fa fa-chevron-left"></i>
          </button>
          <a href="#subview-a" class="fss-nav-item active"></a>
          <a href="#subview-b" class="fss-nav-item"></a>
          <button type="button" class="fss-nav-btn fss-subview-next">
            <i class="fa fa-chevron-right"></i>
          </button>
        </div>-->

  <div fss-anchor="subview-a" class="fss-subview-item subview-a" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
  
  <div class="box">
  <div class="info">
  <form class="inner-form">
  <div class="form-group">
  <label style="font-size:22px;" for="exampleFormControlInput1">1 - Test Example </label>
  <div class="p-2">  </div>
  <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Place your answer here">
  <div class="p-2">  </div>
  <button type="button" onclick="javascript: resetActive(event, 10);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>
  </div> 
  </form>
  </div>
  </div>
  </div>

        <div fss-anchor="subview-b" class="fss-subview-item fss-active" style="">
        <!--<div class="box">
            <div class="info">Subview B</div>
          </div>-->
        </div>
      </div>
    </div>

    <div fss-anchor="view-3" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
      <div class="box">
        <div class="info">
<form class="form-group multiple-selection">

 <!-- <select class="mdb-select md-form" multiple>
  <option value="" disabled selected>Choose your country</option>
  <option value="1">USA</option>
  <option value="2">Germany</option>
  <option value="3">France</option>
  <option value="3">Poland</option>
  <option value="3">Japan</option>
</select> --->

<label class="mdb-main-label">2 - Multiple Choice</label>

<div class="p-2">  </div>

<div style="font-size: 14px;" class="list-group">
  <a href="#!" onclick="myFunction()" style="margin-bottom:8px;" class="list-group-item list-group-item-action list-group-item-success rounded-lg" data-toggle="tooltip" data-placement="left" title="Press One"> <span class="badge badge-primary badge-pill">1</span> Hello i am here <i id="myDIV">  </i> </a>

 <a href="#!" style="margin-bottom:8px;" class="list-group-item list-group-item-action list-group-item-success rounded-lg" data-toggle="tooltip" data-placement="left" title="Press Two"> <span class="badge badge-primary badge-pill">2</span> Hello i am here </a>

 <a href="#!" style="margin-bottom:8px;" class="list-group-item list-group-item-action list-group-item-success rounded-lg" data-toggle="tooltip" data-placement="left" title="Press Three"> <span class="badge badge-primary badge-pill">3</span> Hello i am here </a>
</div>

<div class="p-2">  </div>
  
   <button type="button" onclick="javascript: resetActive(event, 20);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>
</form>     
        </div>
      </div>
    </div>

    <div fss-anchor="view-4" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
      <div class="box">
        <div class="info">
        
  <div class="int-tel-direc">
  <form class="form-group directory">
  <label>3 - phone number </label> <br/>
  <input id="phone" class="form-control phone-direc" name="phone" placeholder="98546 89965" type="tel">
  
  <div class="p-2">  </div>
  <button type="button" onclick="javascript: resetActive(event, 30);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>
  </form>
  </div>

</div>
</div>
</div>

<div fss-anchor="view-5" class="fss-mainview" style="background-color:white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<form class="form-group multiple-selection">
<label class="mdb-main-label">5 -  Yes or NO</label>
<!-- Material checked -->

<!---<div class="form-check">
<input type="checkbox" class="form-check-input" id="materialChecked2" placeholder="yes">
<label class="form-check-label" for="materialChecked2"> YES </label>
<br/>
<input type="checkbox" class="form-check-input" id="materialChecked3" placeholder="No">
<label class="form-check-label" for="materialChecked3"> NO </label>
</div>--->

<div style="font-size: 14px;" class="list-group">
<a href="#!" onclick="myFunction()" style="margin-bottom:8px;" class="list-group-item list-group-item-action list-group-item-success rounded-lg" data-toggle="tooltip" data-placement="left" title="Press A"> <span class="badge badge-primary badge-pill">A</span>Yes <i id="myDIV">  </i> </a>

<a href="#!" style="margin-bottom:8px;" class="list-group-item list-group-item-action list-group-item-success rounded-lg" data-toggle="tooltip" data-placement="left" title="Press B"> <span class="badge badge-primary badge-pill">B</span> No </a>

</div>

<div class="p-2">  </div>
<button type="button" onclick="javascript: resetActive(event, 40);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>
</form>     
</div>
</div>
</div>


<div fss-anchor="view-6" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<form class="inner-form">
<div class="form-group">
<label style="font-size:22px;" for="exampleFormControlInput1">6 - Your Email ID</label>
<div class="p-2">  </div>
<!-- <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="somebody@example .com"> --->

<div class="p-2">  </div>
<input type="email" class="form-control" id="exampleFormControlInput1"placeholder="somebody@example.com">
<div class="p-2">  </div>
<button type="button" onclick="javascript: resetActive(event, 60);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>

</div> 
</form>
</div>
</div>
</div>


<div fss-anchor="view-7" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<form class="form-group color-change">

<label style="font-size:22px;"> 7 - Option Scale </label>
<div class="p-2">  </div>

<div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
<label class="btn btn-secondary active">
<input type="radio" name="options" id="option1" autocomplete="off"> 0
</label>
<label class="btn btn-secondary">
<input type="radio" name="options" id="option2" autocomplete="off"> 1
</label>
<label class="btn btn-secondary">
<input type="radio" name="options" id="option3" autocomplete="off"> 2
</label>

<label class="btn btn-secondary">
<input type="radio" name="options" id="option3" autocomplete="off"> 3
</label>
<label class="btn btn-secondary">
<input type="radio" name="options" id="option3" autocomplete="off"> 4
</label>
<label class="btn btn-secondary">
<input type="radio" name="options" id="option3" autocomplete="off"> 5
</label>
<label class="btn btn-secondary">
<input type="radio" name="options" id="option3" autocomplete="off"> 6
</label>
<label class="btn btn-secondary">
<input type="radio" name="options" id="option3" autocomplete="off"> 7
</label>

<label class="btn btn-secondary">
<input type="radio" name="options" id="option3" autocomplete="off"> 8
</label>

<label class="btn btn-secondary">
<input type="radio" name="options" id="option3" autocomplete="off"> 9
</label>

<label class="btn btn-secondary">
<input type="radio" name="options" id="option3" autocomplete="off"> 10
</label>
</div>

<div class="p-2">  </div>
<button type="button" onclick="javascript: resetActive(event, 70);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>
</form>

</div>
</div>
</div>


<div fss-anchor="view-8" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<form class="form-group">

<label class="mdb-main-label">8 - Star Rating...</label>

<form>
<div class="rating"> <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label> <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label> <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label> <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label> <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
</div>

<div class="p-2">  </div>
<button style="float: left;" type="button" onclick="javascript: resetActive(event, 80);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>
</form>
<hr>


</div>

</div>

</div>


<div fss-anchor="view-9" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<form class="inner-form">
<div class="form-group">
<label style="font-size:22px;" for="exampleFormControlInput1">9 - Choose your Date...</label>
<div class="p-2">  </div>
<input style="width: 70px; font-size: 24px; border-color: #2257af; text-align: center;" type="text" id="DD" name="DD" placeholder="DD" maxlength="2" size="2"> / <input style="width: 80px; font-size: 24px; border-color: #2257af; text-align: center;" type="text" id="MM" name="MM" placeholder="MM" maxlength="2" size="2"> / <input style="width: 115px; font-size: 24px; border-color: #2257af; text-align: center;" type="text" id="YEAR" name="YEAR" placeholder="YYYY" maxlength="4" size="4">
</div>
<div class="p-2">  </div>
<button style="margin-right: 106px;" type="button" onclick="javascript: resetActive(event, 90);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>  
</form> 
</div>
</div>
</div>
    

<div fss-anchor="view-10" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<form class="inner-form">
<div class="form-group">
<label style="font-size:22px;" for="exampleFormControlInput1">9 - drag and drop...</label>
<div class="p-2">  </div>
<select class="custom-select">
<option selected>Select an Option</option>
<option value="1">One</option>
<option value="2">Two</option>
<option value="3">Three</option>
</select>
<div class="p-2">  </div>
<button type="button" onclick="javascript: resetActive(event, 100);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>
</div>
</form> 
</div>
        
     </div>
    </div>


<div fss-anchor="view-11" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<form class="inner-form">
<div class="container">

<form  class="form-group" method="post" action="#" id="#">

<div class="form-group-files files">
<label>10 - Upload Your File </label>
<div class="p-2">  </div>
<i class="fa fa-cloud-upload fa-4x files-icon"></i>
<input type="file" class="form-controls" multiple="">
</div>
</form>
<div class="p-2">  </div>
<button type="button" onclick="javascript: resetActive(event, 100);" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>
</div>
</div>
</form> 
</div>
</div>


<div fss-anchor="view-12" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<div class="multi-images">
<form  class="form-group">
<label>11 - Select Multi Images </label>
<div class="p-2">  </div>
<div class="example-preview source-code" data-hl="html">
<div class="row">
<div class="col-md-3">
<div class="custom-control custom-checkbox image-checkbox">
<input type="checkbox" class="custom-control-input" id="ck1a">
<label class="custom-control-label" for="ck1a">
<img src="img/annie-spratt.jpg" alt="#" class="img-fluid">
<span class="multi-img-data" data-toggle="tooltip" data-placement="left" title="Tooltip on left"> Select A </span>
</label>
</div>
</div>
<div class="col-md-3">
<div class="custom-control custom-checkbox image-checkbox">
<input type="checkbox" class="custom-control-input" id="ck1b">
<label class="custom-control-label" for="ck1b">
<img src="img/luca-bravo.jpg" alt="#" class="img-fluid">
<span class="multi-img-data" data-toggle="tooltip" data-placement="left" title="Tooltip on left"> Select B </span>
</label>
</div>
</div>
<div class="col-md-3">
<div class="custom-control custom-checkbox image-checkbox">
<input type="checkbox" class="custom-control-input" id="ck1c">
<label class="custom-control-label" for="ck1c">
<img src="img/muneeb-syed.jpg" alt="#" class="img-fluid">
<span class="multi-img-data" data-toggle="tooltip" data-placement="left" title="Tooltip on left"> Select C </span>
</label>
</div>
</div>
<div class="col-md-3">
<div class="custom-control custom-checkbox image-checkbox">
<input type="checkbox" class="custom-control-input" id="ck1d">
<label class="custom-control-label" for="ck1d">
<img src="img/vladimir-kudinov.jpg" alt="#" class="img-fluid">
<span class="multi-img-data" data-toggle="tooltip" data-placement="left" title="Tooltip on left"> Select D </span>
</label>
</div>
</div>
</div>
</div>

<div class="p-2">  </div>
<button type="button" onclick="" class="btn btn-custom-color fss-mainview-next"">Submit <i class="fa fa-check"></i></button>
</form>
</div>  
</div>
</div>
</div>


<div fss-anchor="view-13" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<form class="inner-form">
<div class="form-group">
<label style="font-size:22px;" for="exampleFormControlInput1">12 - Website URL...</label>
<div class="p-2">  </div>
<!-- <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="somebody@example .com"> --->

<div class="p-2">  </div>
<input type="text" class="form-control" id="exampleFormControlInput1"placeholder="https://">
<div class="p-2">  </div>
<button type="button" onclick="" class="btn btn-custom-color fss-mainview-next">Submit <i class="fa fa-check"></i></button>

</div> 
</form>
</div>
</div>
</div>


<div fss-anchor="view-14" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<form class="inner-form">
<div class="container-fluid py-3">
<div class="row">
<div class="col-12">
<div id="pay-invoice" class="card">
<div class="card-body">
<div class="card-title">
<h3 class="text-center">Credit Card Payment </h3>
</div>
<hr>
<form action="/echo" method="post" novalidate="novalidate" class="needs-validation">


<div class="form-group">
<label for="cc-number" class="control-label mb-1">Card number</label>
<input id="cc-number" name="cc-number" type="tel" class="form-control cc-number identified visa" required autocomplete="off"  >
<span class="invalid-feedback">Enter a valid 12 to 16 digit card number</span>
</div>
<div class="row">
<div class="col-6">
<div class="form-group">
<label for="cc-exp" class="control-label mb-1">Expiration</label>
<input id="cc-exp" name="cc-exp" type="tel" class="form-control cc-exp" required placeholder="MM / YY" autocomplete="cc-exp">
<span class="invalid-feedback">Enter the expiration date</span>
</div>
</div>
<div class="col-6">
<label for="x_card_code" class="control-label mb-1">CVV</label>
<div class="input-group">
<input id="x_card_code" name="x_card_code" type="tel" class="form-control cc-cvc" required autocomplete="off">
<span class="invalid-feedback order-last">Enter the 3-digit code on back</span>
<div class="input-group-append">
<div class="input-group-text">
<span class="fa fa-question-circle fa-lg" data-toggle="popover" data-container="body" data-html="true" data-title="CVV" 
data-content="<div class='text-center one-card'>The 3 digit code on back of the card..<div class='visa-mc-cvc-preview'></div></div>"
data-trigger="hover"></span>
</div>
</div>
</div>
</div>
</div>

<div>
<button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block fss-mainview-next">
<i class="fa fa-lock fa-lg"></i>&nbsp;
<span id="payment-button-amount">Pay </span>
<span id="payment-button-sending" style="display:none;">Sending…</span>
</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</form> 
</div>
</div>
</div>  


<div fss-anchor="view-15" class="fss-mainview" style="background-color: white; background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div class="box">
<div class="info">
<div class="element-animation">
<div class=""> <i class="fa fa-thumbs-up faa-bounce animated faa-slow"></i> 
</div>
</div>
<img src="./img/blushing.gif" alt=""> </img>
<div class="exit-screen-text"> <p> Thanks for completing this Survay. </p> </div>
</div>
</div>
</div>

<!-- SCRIPTS START -->
@push('footer-script')
<script src="{{ asset('//maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js') }}"></script>
<script src="{{ asset('survey-pages/js/mdb.min.js') }}"></script>
<script src="{{ asset('survey-pages/js/mdbFsscroller.min.js') }}"></script>
<script src="{{ asset('survey-pages/js/intlTelInput.js') }}"></script>
 <script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      utilsScript: "{{ asset('survey-pages/js/utils.js') }}"
    });
    
    $(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
-->
  </script>
  
  <script type="text/javascript">
    function resetActive(event, percent) {
        $(".progress-bar").css("width", percent + "%").attr("aria-valuenow", percent);
        $(".progress-completed").text(percent + "%");

        $("div").each(function () {
            if ($(this).hasClass("activestep")) {
                $(this).removeClass("activestep");
            }
        });

        if (event.target.className == "col-md-2") {
            $(event.target).addClass("activestep");
        }
        else {
            $(event.target.parentNode).addClass("activestep");
        }
    }
</script>
  
  <script>
$(window).scroll(function() {
  
  // selectors
  var $window = $(window),
      $body = $('body'),
      $panel = $('.panel');
  
// Change 33% earlier than scroll position so colour is there when you arrive.
var scroll = $window.scrollTop() + ($window.height() / 3);

$panel.each(function () {
var $this = $(this);

// if position is within range of this panel.
// So position of (position of top of div <= scroll position) && (position of bottom of div > scroll position).
// Remember we set the scroll to 33% earlier in scroll var.
if ($this.position().top <= scroll && $this.position().top + $this.height() > scroll) {

// Remove all classes on body with color-
$body.removeClass(function (index, css) {
return (css.match (/(^|\s)color-\S+/g) || []).join(' ');
});

// Add class of currently active div
$body.addClass('color-' + $(this).data('color'));
}
});    

}).scroll();

</script>
<script> 
// Material Select Initialization
</script>       


<script>
    $(document).ready(function () {
        $('.mdb-select').materialSelect();
      $(".full-screen-scroller").fullScreenScroller();
      $('.mdb-select').materialSelect()
       $('#rateMe2').mdbRate();
    });


</script>
  


<script> 

$(function () {
$('[data-toggle="popover"]').popover()
})



$("#payment-button").click(function(e) {


var form = $(this).parents('form');

var cvv = $('#x_card_code').val();
var regCVV = /^[0-9]{3,4}$/;
var CardNo = $('#cc-number').val();
var regCardNo = /^[0-9]{12,16}$/;
var date = $('#cc-exp').val().split('/');
var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
var regYear = /^20|21|22|23|24|25|26|27|28|29|30|31$/;

if (form[0].checkValidity() === false) {
e.preventDefault();
e.stopPropagation();
}
else {
if (!regCardNo.test(CardNo)) {

$("#cc-number").addClass('required');
$("#cc-number").focus();
alert(" Enter a valid 12 to 16 card number");
return false;
}
else if (!regCVV.test(cvv)) {

$("#x_card_code").addClass('required');
$("#x_card_code").focus();
alert(" Enter a valid CVV");
return false;
}
else if (!regMonth.test(date[0]) && !regMonth.test(date[1]) ) {

$("#cc_exp").addClass('required');
$("#cc_exp").focus();
alert(" Enter a valid exp date");
return false;
}



form.submit();
}

form.addClass('was-validated');
});


</script>
@endpush

@endsection


<style type="text/css">
.navbar-brand {
    display: inline-block;
    padding-top: .3125rem;
    padding-bottom: .3125rem;
    margin-right: 1rem;
    font-size: 1.25rem;
    line-height: inherit;
    white-space: nowrap;

}

</style>
