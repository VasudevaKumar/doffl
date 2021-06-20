@extends('layouts.app')
<?php
//echo '<pre>';
//print_r($paymentlinks);
//exit();

$existingpixelsArray = array(); 

foreach($existingpixels as $key=>$value)
{
   $existingpixelsArray[] = $value->pixel; 
}

if($paymentlinks[0]->paymentLinkType == 2)
{
    $styleCustomer = "style=display:block;";
}
else{
    $styleCustomer = "style=display:none;";
}
?>

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> Edit Payment Link</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">Edit Payment Link</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->

        <!-- /.breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        <label class="control-label">
            <a href="{{ route('admin.paymentLinks') }}" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.Paymentlinks.PaymentList')</a>
        </label>
        </div>

    </div>
@endsection

@section('content')

<div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('modules.Paymentlinks.editPaymentLink')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'createPaymentLink','class'=>'ajax-form','method'=>'POST']) !!}
                            <div class="form-body">


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Paymentlinks.amount')</label>
                                             <input type="number" name="amount" id="amount" value="<?php echo $paymentlinks[0]->amount;?>" class="form-control"   autocomplete="nope">
                                        </div>
                                    </div>

                                    </div>
                                     <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Paymentlinks.purpose')</label>
                                            <input type="text" name="purpose" id="purpose" value="<?php echo $paymentlinks[0]->purpose;?>" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>
                                </div>
                                 

                                <!--/row-->

                                 <div class="row">
                                    <div class="col-md-8    ">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Paymentlinks.PaymentLinkType')</label>

                                             <input type="radio" name="PaymentLinkType" id="PaymentLinkType"  autocomplete="nope" value="1" onClick="displayNoOfCustomers(1);false;" <?php if($paymentlinks[0]->paymentLinkType == 1) {echo "checked";} ?>>&nbsp;@lang('modules.Paymentlinks.group')&nbsp;&nbsp;&nbsp;

                                            <input type="radio" name="PaymentLinkType" id="PaymentLinkType" 
                                                   autocomplete="nope" value="2" onClick="displayNoOfCustomers(2);false;" <?php if($paymentlinks[0]->paymentLinkType == 2) {echo  "checked";} ?>>&nbsp;@lang('modules.Paymentlinks.individual')

                                        </div>
                                    </div>

                                  
                                </div>

                                <!--/row-->
                                
                                
                                <div class="row" id="noOfCustomers" <?php echo $styleCustomer;?>>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Paymentlinks.customeremail')</label>
                                             <input type="text" name="customeremail" id="customeremail" value="<?php echo $paymentlinks[0]->customeremail;?>" class="form-control"
                                                   autocomplete="nope">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Paymentlinks.customerphone')</label>
                                             <input type="number" name="customerphone" id="customerphone" value="<?php echo $paymentlinks[0]->customerphone;?>" class="form-control"
                                                   autocomplete="nope">
                                        </div>
                                    </div>


                                    </div>

                              
                                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Paymentlinks.expiredate')</label>
                                           <input name="expiredate" id="expiredate" value="<?php echo $paymentlinks[0]->expiredate;?>" type="date" min="2013-12-25">
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>


                                 <div class="row">
                                    <div class="col-md-8    ">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Paymentlinks.PaymentType')</label>

                                             <input type="checkbox" name="paypal" id="paypal"                                                    autocomplete="nope" value="1" <?php if($paymentlinks[0]->paypalenabled == 1) {echo "checked";} ?>>&nbsp;@lang('modules.Paymentlinks.paypal')&nbsp;&nbsp;&nbsp;

                                            <input type="checkbox" name="rozarpay" id="rozarpay" 
                                                   autocomplete="nope" value="1" <?php if($paymentlinks[0]->rozerpayenabled == 1) {echo "checked";} ?>>&nbsp;@lang('modules.Paymentlinks.rozarpay')&nbsp;&nbsp;&nbsp;

                                             <input type="checkbox" name="stripe" id="stripe" 
                                                   autocomplete="nope" value="1" <?php if($paymentlinks[0]->stripeenabled == 1) {echo "checked";} ?>>&nbsp;@lang('modules.Paymentlinks.stripe')


                                        </div>
                                    </div>

                                  
                                </div>

                                <?php 
                                if(!empty($pixels)) { ?> 
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>@lang('modules.KBSettings.pixel')</label>
                                            <br />
                                             <select class="selectpicker" multiple name="pixels[]" id="pixels">
                                                  <?php 
                                                  foreach($pixels as $key=>$pixel) { ?>
                                                    <option value="<?php echo $pixel->id;?>" 
                                                        <?php 
                                                            if(in_array($pixel->id, $existingpixelsArray))
                                                                {?>
                                                                    selected ="selceted"
                                                            <?php } 
                                                        ?>
                                                        ><?php echo $pixel->pixelName;?></option>
                                                <?php } ?>

                                                </select>
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>
                                <?php } ?>




                              


                            </div>
                            <div class="form-actions">
                                <input type="hidden" name="paymentLinkID" id="paymentLinkID" value="<?php echo $paymentlinks[0]->id;?>">
                                <button type="submit" id="save-form" class="btn btn-success" onClick="validateForm(); return false;"> <i class="fa fa-check"></i> @lang('app.save')</button>

                                <div id ="errorMsg" name="errorMsg" class="alert-danger" style="display:none; padding:8px; margin-top: 10px; ">
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->



@endsection


@push('footer-script')

 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
     function displayNoOfCustomers(type)
    {   $("#noOfCustomers").hide();
        

       if(type == 2)
        {
            $("#noOfCustomers").show();
        }   
        if(type ==1)
        {
            
            $("#noOfCustomers").hide();
            
        }   

    }


    function validateForm()
    {
        var isSubmit = true;
        

        $("#errorMsg").html('');
        $("#errorMsg").hide();
        

        var PaymentLinkTypeVal = '';
        var purpose = $("#purpose").val();
        var customeremail = $("#customeremail").val();
        var customerphone   = $("#customerphone").val();


        if($("#company_name").val() == '')
        {
            $("#errorMsg").html('Company name is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }

        if($("#amount").val() == '')
        {
            $("#errorMsg").html('Amount is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }

        

        if(purpose == '')
        {
            $("#errorMsg").html('Purpose is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }
        else if(purpose!='')
        {
            var pattern = /^([a-zA-Z]+\s)*[a-zA-Z]+$/;
            if(!pattern.test(purpose))
            {
                    $("#errorMsg").show();
                    $("#errorMsg").html('Purpose should not have the special characters');
                    isvalied = false;
            }

        }


        if ($('input[name="PaymentLinkType"]:checked').length == 0) {
            $("#errorMsg").html('Payment link is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }
        else{
            PaymentLinkTypeVal = $('input[name="PaymentLinkType"]:checked').val();
        }

        if(PaymentLinkTypeVal == 2)
        {
            if(customeremail == '')
            {
                $("#errorMsg").html('Customer email is required');
                $("#errorMsg").show('');
                isSubmit = false;
            }
            else if(customeremail!='')
            {
                var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                if(!pattern.test(customeremail))
                {
                        $("#errorMsg").show();
                        $("#errorMsg").html('Please enter valid email address');
                        isvalied = false;
                }
            }

            if(customerphone == '')
            {
                $("#errorMsg").html('Customer phone is required');
                $("#errorMsg").show('');
                isSubmit = false;
            }
            else if(customerphone!='')
            {
                var pattern = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/i;

                if(!pattern.test(customerphone))
                {
                        $("#errorMsg").show();
                        $("#errorMsg").html('Please enter valid phone number');
                        isvalied = false;
                }
            }

        }

        if($("#expiredate").val() == '')
        {
            $("#errorMsg").html('Expire date is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }

        if ($('input[type="checkbox"]:checked').length == 0) {
            $("#errorMsg").html('Payment type is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }
        

        
       
        

       if(isSubmit)
    {
       //alert('added');
       $("#errorMsg").html('');
        $("#errorMsg").hide();

       $.easyAjax({
            url: '{{route('admin.updatePaymentLink')}}',
            container: '#createPaymentLink',
            type: "POST",
            data: $('#createPaymentLink').serialize(),
            file:  true,
            success: function (response) {
                if (response.status == 'success') {
                  
                    var url = '{{ route('admin.paymentLinks')}}';
                     location.href = url;
                     
                }else{
                    // console.log(response);
                    $("#errorMsg").show();
                    $("#errorMsg").html(response.message);
                }
            }
        });
        


    }

    }



    /*
        serviceName
        servieDescription
        serviceDuration
        bookingType
        startDate
        endDate
        singleDay


    */

    
function displayNoOfSlots(noOfSlots)
{
   // alert(noOfSlots);
   var timeSlotString = '';

   for(var i=0; i < noOfSlots; i++)
   {
        timeSlotString += '<div class="row"><div class="col-md-4"><div class="form-group"><label class="required">Start Time</label><input type="time" name="startTime[]" class="form-control time_input" autocomplete="nope"></div></div><div class="col-md-4"><div class="form-group"><label class="required">End Time</label><input type="time" name="endTime[]" class="form-control time_input" autocomplete="nope"></div></div><div class="col-md-4"><div class="form-group"><label class="required">seats</label><input type="number" name="seats[]" class="form-control time_input" autocomplete="nope"></div></div></div>';

        $("#timeSlots").html(timeSlotString);
   }
}

function displayPayment(paymentType)
{
    $("#paymentOption").hide();
    $("#paymentAmt").hide();
    $('input[name=paymentMethod]:checked').removeAttr('checked');

    if(paymentType == 2)
    {
        $("#paymentOption").show();
    }
}

function displayPaymentAmt(paymentMethod)
{
        $("#paymentAmt").hide();
        if(paymentMethod == 1)
        {
            $("#paymentAmt").show();
        }
}


var tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
var today = tomorrow.toISOString().split('T')[0];
document.getElementsByName("expiredate")[0].setAttribute('min', today);

</script>
@endpush

<style type="text/csss">


</style>
