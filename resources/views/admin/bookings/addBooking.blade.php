@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->

        <!-- /.breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        <label class="control-label">
            <a href="{{ route('admin.bookings') }}" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.Bookings.BookingList')</a>
        </label>
        </div>

    </div>
@endsection
@section('content')

<div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('modules.Bookings.addBooking')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'createBooking','class'=>'ajax-form','method'=>'POST']) !!}
                            <div class="form-body">

                                <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group" >
                                        <label class="control-label">@lang('modules.client.companyName')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                            <select class="selectpicker" data-width="fit" name="company_name" id="company_name">
                                                        <option value="">Please choose</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.serviceName')</label>
                                             <input type="text" name="serviceName" id="serviceName" class="form-control"
                                                   autocomplete="nope">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.servieDescription')</label>
                                            <input type="text" name="servieDescription" id="servieDescription" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.serviceDuration')</label>
                                            <input type="number" name="serviceDuration" id="serviceDuration" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>

                                <!--/row-->

                                 <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.types')</label>

                                             <input type="radio" name="bookingType" id="bookingType"                                                    autocomplete="nope" value="1" onClick="displayDates(1);false;">&nbsp;@lang('modules.Bookings.once')&nbsp;&nbsp;&nbsp;

                                            <input type="radio" name="bookingType" id="bookingType" 
                                                   autocomplete="nope" value="2" onClick="displayDates(2);false;">&nbsp;@lang('modules.Bookings.daily')

                                        </div>
                                    </div>

                                  <div style="margin:0px; padding:0px; display: none;" id="multipleDates">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.startDate')</label>
                                            <input type="date" name="startDate" id="startDate" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.endDate')</label>
                                            <input type="date" name="endDate" id="endDate" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>
                                </div>

                                <div style="margin:0px; padding:0px; display: none;" id="singleDate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.Date')</label>
                                            <input type="date" name="singleDay" id="singleDay" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>

                                </div>

                                   <!--/span-->
                                </div>

                                <!--/row-->

                                <div class="row">
                                    <div class="col-md-5" id="dailyWeeks" style="display: none;">
                                        
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="7">Sunday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]"><option value="1">Available</option><option value="2">Closed</option></select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="1">Monday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]"><option value="1">Available</option><option value="2">Closed</option></select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="2">Tuesday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]"><option value="1">Available</option><option value="2">Closed</option></select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="3">Wednesday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]"><option value="1">Available</option><option value="2">Closed</option></select>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="4">Thrusday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]"><option value="1">Available</option><option value="2">Closed</option></select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="5">Friday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]"><option value="1">Available</option><option value="2">Closed</option></select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="6">Saturday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]"><option value="1">Available</option><option value="2">Closed</option></select>
                                                </td>
                                            </tr>


                                        </table>

                                    </div>

                                    

                                   <!--/span-->
                                </div>

                                <!--/row-->


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.noOfSlots')</label>
                                             <input type="number" name="numberOfSlots" id="numberOfSlots" class="form-control"
                                                   autocomplete="nope" onChange="displayNoOfSlots(this.value)">
                                        </div>
                                    </div>
                                   <!--/span-->
                                </div>

                                <!--/row-->

                                <div class="row">
                                    <div class="col-md-4" id="timeSlots">
                                            
                                     


                                    </div>
                                   <!--/span-->
                                </div>

                                <!--/row-->

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.payment')</label>

                                             <input type="radio" name="paymentType" id="paymentType" autocomplete="nope" value="1" onClick="displayPayment(1);false;">&nbsp;@lang('modules.Bookings.free')&nbsp;&nbsp;&nbsp;

                                            <input type="radio" name="paymentType" id="paymentType" 
                                                   autocomplete="nope" value="2" onClick="displayPayment(2);false;">&nbsp;@lang('modules.Bookings.paid')

                                        </div>

                                    </div>

                                  <div class="col-md-3" style="margin:0px; padding:0px; display: none;" id="paymentOption">
                                        
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.paymentmethod')</label>
                                             <input type="radio" name="paymentMethod" id="paymentMethod" autocomplete="nope" value="1" onClick="displayPaymentAmt(1);false;">&nbsp;@lang('modules.Bookings.online')&nbsp;&nbsp;&nbsp;

                                            <input type="radio" name="paymentMethod" id="paymentMethod" 
                                                   autocomplete="nope" value="2" onClick="displayPaymentAmt(2);false;">&nbsp;@lang('modules.Bookings.local')

                                        </div>
                                    

                                </div>

                                    <div class="col-md-3" style="margin:0px; padding:0px; display: none;" id="paymentAmt">


                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.amt')</label>
                                             <input type="number" name="paymentAmount" id="paymentAmount"                                                    autocomplete="nope" value="">

                                        </div>

                                    </div>
                                

                                   <!--/span-->
                                </div>


                                <div class="row">
                                    <label class="required">@lang('modules.Bookings.remember')</label>
                                    <div class="col-md-12">

                                        
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            

                                        
                                             <input type="number" name="rememberAfter" id="rememberAfter" class="form-control"
                                                   autocomplete="nope">
                                            </div>
                                        </div>

                                            <div class="col-md-8">
                                            <select class="selectpicker" name="rememberAfterValue" id="rememberAfterValue">
                                                <option value="1">Minutes</option>
                                                <option value="2">Hours</option>
                                                <option value="3">Days</option>
                                            </select>
                                            </div>
                                       

                                    </div>

                                 

                                

                                   <!--/span-->
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
                                                    <option value="<?php echo $pixel->id;?>"><?php echo $pixel->pixelName;?></option>
                                                <?php } ?>

                                                </select>
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>
                                <?php } ?>



                                


                            </div>
                            <div class="form-actions">
                                <button type="submit" id="save-form" class="btn btn-success" onClick="validateForm(); return false;"> <i class="fa fa-check"></i> @lang('app.save')</button>

                                <div id ="errorMsg" name="errorMsg" class="alert-danger" style="display:none; padding:8px; ">
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
     function displayDates(type)
    {   $("#dailyWeeks").hide();
        $("#multipleDates").hide();
        $("#singleDate").hide();

       if(type ==1)
        {
            $("#singleDate").show();
        }   
        if(type ==2)
        {
            
            $("#multipleDates").show();
            $("#dailyWeeks").show();
        }   

    }


    function validateForm()
    {
        var isSubmit = true;
        

        $("#errorMsg").html('');
        $("#errorMsg").hide();
        $("#paymentAmt").hide();

        var bookingTypeVal = '';
        var paymentTypeVal = '';

        if($("#company_name").val() == '')
        {
            $("#errorMsg").html('Company name is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }

        

        if($("#serviceName").val() == '')
        {
            $("#errorMsg").html('Service name is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }

        if($("#servieDescription").val() == '')
        {
            $("#errorMsg").html('Service description is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }

        if($("#serviceDuration").val() == '')
        {
            $("#errorMsg").html('Service duration is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }

        if($("#serviceDuration").val() == '')
        {
            $("#errorMsg").html('Service duration is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }

        if ($('input[name="bookingType"]:checked').length == 0) {
            $("#errorMsg").html('Booking type is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }
        else{
            bookingTypeVal = $('input[name="bookingType"]:checked').val();
        }

        if(bookingTypeVal == 2)
        {
            if($("#startDate").val() == '')
            {
                $("#errorMsg").html('Start date is required');
                $("#errorMsg").show('');
                isSubmit = false;
            }
            else if($("#endDate").val() == '')
            {
                $("#errorMsg").html('End date is required');
                $("#errorMsg").show('');
                isSubmit = false;   
            }
            else if($("#startDate").val()!='' && $("#endDate").val())
            {
                let startDateStamp = new Date($("#startDate").val());
                let endDateStamp = new Date($("#endDate").val());

                if(startDateStamp > endDateStamp)
                {
                    $("#errorMsg").html('Start date should not be greater than the end date');
                    $("#errorMsg").show('');
                    isSubmit = false;          
                }
            }
        }

        if(bookingTypeVal == 1)
        {
            if($("#singleDay").val() == '')
            {
                $("#errorMsg").html('Date is required');
                $("#errorMsg").show('');
                isSubmit = false;
            }
        }

        if($("#numberOfSlots").val() == '')
        {
            $("#errorMsg").html('No of slots is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }

        if ($('input[name="paymentType"]:checked').length == 0) {
            $("#errorMsg").html('Payment type is required');
            $("#errorMsg").show('');
            isSubmit = false;
        }
        else{
            paymentTypeVal = $('input[name="paymentType"]:checked').val();
        }

        
        if(paymentTypeVal ==2 )
        {
        
            
                if ($('input[name="paymentMethod"]:checked').length == 0) {
                    $("#errorMsg").html('Payment method is required');
                    $("#errorMsg").show('');
                    isSubmit = false;
                }

                var paymentMethodVal = $('input[name="paymentMethod"]:checked').val();

                if(paymentMethodVal == 1)
                {
                        $("#paymentAmt").show();

                        if($("#paymentAmount").val()=='')
                        {
                            $("#errorMsg").html('Amount is required');
                            $("#errorMsg").show('');
                            isSubmit = false;
                        }

                        if($("#paymentAmount").val()!='')
                        {
                            var paymentAmountVal = $("#paymentAmount").val();

                            var pattern = /^(0|[1-9]\d*)$/;
                            if(!pattern.test(paymentAmountVal))
                            {
                                    $("#errorMessage").show();
                                    $("#errorMessage").html('Amount should be numeric only.');
                                    isvalied = false;
                            }
                        }

                }


            
        }
        
        

        if(isSubmit)
        {

       //alert('added');
       $("#errorMessage").html('');
        $("#errorMessage").hide();

       $.easyAjax({
            url: '{{route('admin.saveBooking')}}',
            container: '#createBooking',
            type: "POST",
            data: $('#createBooking').serialize(),
            file:  true,
            success: function (response) {
                if (response.status == 'success') {
                  
                    var url = '{{ route('admin.bookings')}}';
                     location.href = url;
                     
                }else{
                    // console.log(response);
                    $("#errorMessage").show();
                    $("#errorMessage").html(response.message);
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

        if(paymentMethod == 2)
        {
            $("#paymentAmt").show();
        }

}


var tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
var today = tomorrow.toISOString().split('T')[0];

document.getElementsByName("startDate")[0].setAttribute('min', today);
document.getElementsByName("endDate")[0].setAttribute('min', today);
document.getElementsByName("singleDay")[0].setAttribute('min', today);


</script>
@endpush

<style type="text/csss">


</style>
