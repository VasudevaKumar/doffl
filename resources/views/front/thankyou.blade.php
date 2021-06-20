<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title> {{ __($pageTitle) }} | {{ ucwords($setting->company_name)}}</title>

    <!-- Bootstrap CSS -->
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/vendor/animate-css/animate.min.css') }}">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/vendor/slick/slick.css') }}">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/vendor/slick/slick-theme.css') }}">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/fonts/flaticon/flaticon.css') }}">
    <link href="{{ asset('front/plugin/froiden-helper/helper.css') }}" rel="stylesheet">
    <!-- Template CSS -->
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/css/main.css') }}">
    <!-- Template Font Family  -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&family=Rubik:wght@400;500&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" media="all"
          href="{{ asset('saas/vendor/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <style>
        :root {
            --main-color: {{ $frontDetail->primary_color }};
        }
        .help-block {
            color: #8a1f11 !important;
        }

    </style>
</head>

<body id="home">


<!-- Topbar -->
@include('sections.saas.saas_header')
<!-- END Topbar -->

<!-- Header -->
<!-- END Header -->


<section class="sp-100 login-section" id="section-contact">
    <div class="container">
        <div class="login-box mt-5 shadow bg-white form-section">
            <h4 class="mb-0 text-left text-uppercase">
               Thank you.
            </h4>
            {!! Form::open(['id'=>'register', 'method'=>'POST']) !!}
            <div class="row">
               <div id="alert" class="col-lg-12 col-12">
                </div>

                <div class="col-12" id="form-box">
                    
                    <div class="col-lg-12 col-12">
                        <div class="alert alert-success">Thank you for signing up. Please login to get started <a href=" {{ Session::get('loginUrl')}}">Login Now</a>.</div>
                    </div>

                </div>
            </div>
            {!! Form::close() !!}
        </div>

       <div class="login-box mt-5 shadow bg-white send-mail">
                    {!! Form::open(['id'=>'mail','class'=>'row', 'method'=>'POST']) !!}
                    <h2 class="text-center m-b-15">Resend Verification Mail</h2>
                    <p id="alert"></p>
                   <div class="col-12" id="mail-box">
                        <div class="form-group mb-4">
                        <label for="email">{{ __('app.yourEmailAddress') }}</label>
                         <input type="text" class="form-control" id="reverify_email" name="reverify_email" placeholder="Registered Email Id">
                    </div>
                         <button type="button" class="btn btn-lg btn-success mt-2" id="send-mail">
                        Send
                    </button>
                    </div>
                </div>
                {!! Form::close() !!}
        
        
    </div>
                

    </div>
</section>

<!-- END Main container -->

<!-- Cta -->
{{--@include('saas.sections.cta')--}}
<!-- End Cta -->

<!-- Footer -->
@include('sections.saas.saas_footer')
<!-- END Footer -->



<!-- Scripts -->
<script src="{{ asset('saas/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('saas/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('saas/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('saas/vendor/wowjs/wow.min.js') }}"></script>
<script src="{{ asset('front/plugin/froiden-helper/helper.js') }}"></script>
<script src="{{ asset('saas/js/main.js') }}"></script>
<script src="{{ asset('front/plugin/froiden-helper/helper.js') }}"></script>
<!-- Global Required JS -->

<script type="text/javascript">
    
    $('#send-mail').click(function () {
            $.easyAjax({
                url: '{{route('front.resend-verification')}}',
                container: '.send-mail',
                type: "POST",
                data: $('#mail').serialize(),
                messagePosition: "inline",
                success: function (response) {
                    if(response.status == 'success'){
                        $('#mail-box').remove();
                    }else if (response.status == 'fail')
                    {
                        @if(!is_null($global->google_recaptcha_key))
                            grecaptcha.reset();
                        @endif

                    }
                }
            })
        });

</script>

</body>
</html>
