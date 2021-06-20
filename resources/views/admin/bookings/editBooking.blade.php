@extends('layouts.app')

<?php
/*
echo '<pre>';
print_r($bookingslots);
exit();
*/

$noOfSlots = 0;
$takenSlots = 0;

$countbookingslots = count($bookingslots);

if(!empty($seatsTaken))
{
    $takenSlots = $seatsTaken[0]->seatstaken;
}

$multipleDateCss =  'display:none;';
$singleDayCss = 'display:none;';
$paymentOptionsCss = 'display:none;';

if($bookings[0]->NoOfSlots!='')
{
    $noOfSlots = $bookings[0]->NoOfSlots;
}

if($bookings[0]->bookingType == 2)
{
     $multipleDateCss = 'display:block';
     
}

if($bookings[0]->bookingType == 1)
{
     $singleDayCss = 'display:block';
}

if($bookings[0]->paymentType == 2)
{
      $paymentOptionsCss = 'display:block;';
}


$existingpixelsArray = array(); 

foreach($existingpixels as $key=>$value)
{
   $existingpixelsArray[] = $value->pixel; 
}




?>
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
                <div class="panel-heading"> Edit Booking</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'updateBooking','class'=>'ajax-form','method'=>'POST']) !!}
                            <div class="form-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.serviceName')</label>
                                             <input type="text" name="serviceName" id="serviceName" class="form-control"
                                                   autocomplete="nope" value="<?php echo $bookings[0]->serviceName;?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.servieDescription')</label>
                                            <input type="text" value="<?php echo $bookings[0]->serviceDescription;?>" name="servieDescription" id="servieDescription" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.serviceDuration')</label>
                                            <input type="number" name="serviceDuration" id="serviceDuration" class="form-control" autocomplete="nope" value="<?php echo $bookings[0]->serviceDuration;?>">
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>

                                <!--/row-->

                                 <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.types')</label>
                                            <?php if($takenSlots > 0) { ?>
                                             <input type="radio" name="bookingType"  autocomplete="nope" value="1"  <?php if($bookings[0]->bookingType == 1) echo 'checked="checked"';?>>&nbsp;@lang('modules.Bookings.once')&nbsp;&nbsp;&nbsp;

                                            <input type="radio" name="bookingType"  
                                                   autocomplete="nope" value="2" <?php if($bookings[0]->bookingType == 2) echo 'checked="checked"';?>>&nbsp;@lang('modules.Bookings.daily')
                                            <?php } else { ?>

                                                <input type="radio" name="bookingType"  autocomplete="nope" value="1" onClick="displayDates(1);false;" <?php if($bookings[0]->bookingType == 1) echo 'checked="checked"';?>>&nbsp;@lang('modules.Bookings.once')&nbsp;&nbsp;&nbsp;

                                            <input type="radio" name="bookingType"  
                                                   autocomplete="nope" value="2" onClick="displayDates(2);false;" <?php if($bookings[0]->bookingType == 2) echo 'checked="checked"';?>>&nbsp;@lang('modules.Bookings.daily')


                                            <?php } ?>
                                        
                                        </div>
                                    </div>
                                    
                                     <div style="margin:0px; padding:0px; <?php echo $multipleDateCss;?>" id="multipleDates">
                                    <div class="col-md-4">


                                        <?php if($takenSlots <= 0) { ?>
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.startDate')</label>
                                            <input type="date" name="startDate" id="startDate" class="form-control" autocomplete="nope" value="<?php if($bookings[0]->bookingStartDate!='0000-00-00 00:00:00') echo date('Y-m-d', strtotime($bookings[0]->bookingStartDate));?>">
                                        </div>

                                            <?php } else { ?>

                                            <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.startDate')</label>
                                            <input type="text" name="startDate" id="startDate" class="form-control" autocomplete="nope" readonly="true" value="<?php if($bookings[0]->bookingStartDate!='0000-00-00 00:00:00') echo date('Y-m-d', strtotime($bookings[0]->bookingStartDate));?>">
                                            </div>


                                        <?php } ?>

                                    </div>

                                    <div class="col-md-4">

                                        <?php if($takenSlots <= 0) { ?>
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.endDate')</label>
                                            <input type="date" name="endDate" id="endDate" class="form-control" autocomplete="nope" value="<?php if($bookings[0]->bookingEndDate!='0000-00-00 00:00:00') echo date('Y-m-d', strtotime($bookings[0]->bookingEndDate));?>">
                                        </div>

                                         <?php } else { ?>

                                            <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.endDate')</label>
                                            <input type="text" name="endDate" id="endDate" class="form-control" autocomplete="nope" readonly="true" value="<?php if($bookings[0]->bookingEndDate!='0000-00-00 00:00:00') echo date('Y-m-d', strtotime($bookings[0]->bookingEndDate));?>">
                                        </div>


                                        <?php } ?>


                                    </div>
                                    </div>
                                    

                                 <div style="margin:0px; padding:0px; <?php echo $singleDayCss;?>" id="singleDate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php if($takenSlots > 0) { ?>
                                                <label class="required">@lang('modules.Bookings.Date')</label>
                                                <input type="date" name="singleDay" id="singleDay" readonly="true" class="form-control" autocomplete="nope" value="<?php if($bookings[0]->bookingDate!='0000-00-00 00:00:00') echo date('Y-m-d', strtotime($bookings[0]->bookingDate));?>">

                                            <?php } else { ?>
                                            <label class="required">@lang('modules.Bookings.Date')</label>
                                            <input type="date" name="singleDay" id="singleDay" class="form-control" autocomplete="nope" value="<?php if($bookings[0]->bookingDate!='0000-00-00 00:00:00') echo date('Y-m-d', strtotime($bookings[0]->bookingDate));?>">
                                        <?php } ?>


                                        </div>
                                    </div>

                                </div>
                               
                                   <!--/span-->
                                </div>

                                <!--/row-->
                               
                                <div class="row" style=" <?php echo $multipleDateCss;?>" id="dailyWeeks">
                                    <div class="col-md-5">
                                        
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="7">Sunday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]" id="sundayOptions"><option value="1">Available</option><option value="2">Closed</option></select>
                                                    <?php 
                                                    if(!empty($bookingweekly))
                                                    { ?>
                                                    <script type="text/javascript"> document.getElementById("sundayOptions").value = '<?php echo $bookingweekly[0]->isAvailable;?>';</script>
                                                <?php } ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="1">Monday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]" id="MondayOptions"><option value="1">Available</option><option value="2">Closed</option></select>

                                                    <?php 
                                                    if(!empty($bookingweekly))
                                                    { ?>
                                                    <script type="text/javascript"> document.getElementById("MondayOptions").value = '<?php echo $bookingweekly[1]->isAvailable;?>';</script>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="2">Tuesday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]" id="TuesdayOptions"><option value="1">Available</option><option value="2">Closed</option></select>

                                                    <?php 
                                                    if(!empty($bookingweekly))
                                                    { ?>
                                                    <script type="text/javascript"> document.getElementById("TuesdayOptions").value = '<?php echo $bookingweekly[2]->isAvailable;?>';</script>
                                                    <?php } ?>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="3">Wednesday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]" id="WednesdayOptions"><option value="1">Available</option><option value="2">Closed</option></select>

                                                    <?php 
                                                    if(!empty($bookingweekly))
                                                    { ?>
                                                    <script type="text/javascript"> document.getElementById("WednesdayOptions").value = '<?php echo $bookingweekly[3]->isAvailable;?>';</script>
                                                    <?php } ?>

                                                </td>
                                            </tr>


                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="4">Thrusday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]" id="ThrusdayOptions"><option value="1">Available</option><option value="2">Closed</option></select>

                                                    <?php 
                                                    if(!empty($bookingweekly))
                                                    { ?>
                                                    <script type="text/javascript"> document.getElementById("ThrusdayOptions").value = '<?php echo $bookingweekly[4]->isAvailable;?>';</script>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="5">Friday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]" id="FridayOptions"><option value="1">Available</option><option value="2">Closed</option></select>

                                                    <?php 
                                                    if(!empty($bookingweekly))
                                                    { ?>
                                                    <script type="text/javascript"> document.getElementById("FridayOptions").value = '<?php echo $bookingweekly[5]->isAvailable;?>';</script>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 60%;">
                                                    <select class="selectpicker" name="dailyWeek[]"><option value="6">Saturday</option></select>
                                                </td>
                                                <td style="width: 20%; margin-left: 5px;">
                                                    <select class="selectpicker" name="dailyWeekStatus[]" id="SaturydayOptions"><option value="1">Available</option><option value="2">Closed</option></select>

                                                    <?php 
                                                    if(!empty($bookingweekly))
                                                    { ?>
                                                    <script type="text/javascript"> document.getElementById("SaturydayOptions").value = '<?php echo $bookingweekly[6]->isAvailable;?>';</script>
                                                <?php } ?>

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
                                                   autocomplete="nope" onChange="displayNoOfSlots(this.value, <?php echo $countbookingslots;?>)" value="<?php echo $countbookingslots;?>">
                                        </div>

                                    </div>
                                   <!--/span-->
                                </div>

                                <!--/row-->

                                <div class="row">
                                    <div class="col-md-10" id="timeSlots">
                                        <?php 
                                        if($bookings[0]->NoOfSlots!='')
                                        {
                                            $timeSlotString = '';

                                            for($i=0 ; $i < count($bookingslots); $i++)
                                            {

                                                if($bookingslots[$i]->seatstaken>0)
                                                {
                                                    $takenSlots += $bookingslots[$i]->seatstaken;
                                                }
                                                $timeSlotString .= '<div class="row" id="slotID'.$i.'"><div class="col-md-2"><div class="form-group"><label class="required">Booking date</label><input type="text" readonly="true" class="form-control time_input" autocomplete="nope" value="'.$bookingslots[$i]->bookingDate.'"></div></div><div class="col-md-2"><div class="form-group"><label class="required">Start Time</label><input type="time" name="startTime[]" class="form-control time_input" autocomplete="nope" value="'.$bookingslots[$i]->startTime.'"></div></div><div class="col-md-2"><div class="form-group"><label class="required">End Time</label><input type="time" name="endTime[]" class="form-control time_input" autocomplete="nope" value="'.$bookingslots[$i]->endTime.'"></div></div><div class="col-md-2"><div class="form-group"><label class="required">Total Seats</label><input type="number" name="seats[]" class="form-control time_input" autocomplete="nope" id="totalSeats'.$i.'" value="'.$bookingslots[$i]->seats.'" onChange="checkSeats('.$i.');"></div></div> 
                                                <div class="col-md-1 font11"><div class="form-group"><label>Taken</label><input type="number" name="seatstaken[]" class="form-control time_input" autocomplete="nope" value="'.$bookingslots[$i]->seatstaken.'" id="takenSeats'.$i.'" readonly="true"></div></div>
                                                <div class="col-md-1 font11"><div class="form-group"><label>Remaining</label><input type="number" name="seatsremaining[]" id="remainingSeats'.$i.'"class="form-control time_input" autocomplete="nope" value="'.$bookingslots[$i]->seatsremaining.'" readonly="true"><input type="hidden" name="ids[]" class="form-control time_input" autocomplete="nope" value="'.$bookingslots[$i]->id.'"></div></div>';
                                                    
                                                    if($bookingslots[$i]->seatstaken<=0)
                                                    {
                                                        $timeSlotString .= '<div class="col-md-2" style="padding-top:28px;"><a href="#" onClick="deactivateSlot('.$bookingslots[$i]->id.'); return false;">Remove this slot</a></div></div>';
                                                    }
                                                    else{
                                                        $timeSlotString .= '<div class="col-md-2" style="padding-top:28px;"></div></div>';
                                                    }
                                                    
                                                
                                                    
                                            }

                                            echo $timeSlotString;
                                        }
                                        ?>

                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10" id="moreTimeSlots">
                                    </div>
                                   <!--/span-->
                                </div>

                                <!--/row-->

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.payment')</label>

                                            <?php if($takenSlots > 0) { ?>

                                                <input type="radio" name="paymentType" id="paymentType" autocomplete="nope" value="1" <?php if($bookings[0]->paymentType == 1) echo 'checked="checked"';?>>&nbsp;@lang('modules.Bookings.free')&nbsp;&nbsp;&nbsp;

                                            <input type="radio" name="paymentType" id="paymentType" 
                                                   autocomplete="nope" value="2" <?php if($bookings[0]->paymentType == 2) echo 'checked="checked"';?> >&nbsp;@lang('modules.Bookings.paid')

                                            <?php } else { ?>
                                             <input type="radio" name="paymentType" id="paymentType" autocomplete="nope" value="1" onClick="displayPayment(1);false;" <?php if($bookings[0]->paymentType == 1) echo 'checked="checked"';?>>&nbsp;@lang('modules.Bookings.free')&nbsp;&nbsp;&nbsp;

                                            <input type="radio" name="paymentType" id="paymentType" 
                                                   autocomplete="nope" value="2" onClick="displayPayment(2);false;" <?php if($bookings[0]->paymentType == 2) echo 'checked="checked"';?> >&nbsp;@lang('modules.Bookings.paid')
                                            <?php } ?>

                                        </div>


                                    </div>
                                    
                                  <div class="col-md-3" style="margin:0px; padding:0px; <?php echo $paymentOptionsCss;?>" id="paymentOption">
                                        
                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.paymentmethod')</label>
                                             <input type="radio" name="paymentMethod" id="paymentMethod" <?php if($bookings[0]->paymentMethod == 1) echo 'checked="checked"';?> autocomplete="nope" value="1" onClick="displayPaymentAmt(1);false;">&nbsp;@lang('modules.Bookings.online')&nbsp;&nbsp;&nbsp;

                                            <input type="radio" name="paymentMethod" id="paymentMethod" 
                                                   autocomplete="nope" value="2" <?php if($bookings[0]->paymentMethod == 2) echo 'checked="checked"';?> onClick="displayPaymentAmt(2);false;">&nbsp;@lang('modules.Bookings.local')

                                        </div>
                                    

                                </div>
                                    
                                

                                    

                                    <div class="col-md-3" style="margin:0px; padding:0px; <?php echo $paymentOptionsCss;?>" id="paymentAmt">

                                        <div class="form-group">
                                            <label class="required">@lang('modules.Bookings.amt')</label>
                                             <input type="number" name="paymentAmount" id="paymentAmount" autocomplete="nope" value="<?php echo $bookings[0]->paymentAmount;?>">

                                        </div>

                                    </div>
                                
                                   <!--/span-->
                                </div>


                                <div class="row">
                                    <label class="required">@lang('modules.Bookings.remember')</label>
                                    <div class="col-md-12">

                                        
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            

                                        
                                             <input type="number" name="rememberAfter" id="rememberAfter" value="<?php echo $bookings[0]->rememberType;?>" class="form-control"
                                                   autocomplete="nope">
                                            </div>
                                        </div>

                                            <div class="col-md-8">
                                            <select class="selectpicker" id="rememberAfterValue" name="rememberAfterValue">
                                                <option value="1">Minutes</option>
                                                <option value="2">Hours</option>
                                                <option value="3">Days</option>
                                            </select>
                                            <script type="text/javascript">
                                            $("#rememberAfterValue").val('<?php echo $bookings[0]->rememberAfter;?>');
                                            </script>
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
                                <input type="hidden" name="bookingID" value="<?php echo $bookings[0]->id;?>">
                                <input type="hidden" name="takenSlots" id="takenSlots" value="<?php echo $takenSlots;?>">
                                
                                <button type="submit" id="save-form" class="btn btn-success" onClick="validateForm(); return false;"> <i class="fa fa-check"></i> @lang('app.save')</button>

                                <div id ="errorMessage" name="errorMessage" class="alert-danger" style="display:none; padding:8px; ">
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

<style type="text/css">
    .font11{
        font-size: 11px;
    }
</style>

@endsection


@push('footer-script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    function displayDates(type)
    {   
        // alert('here');
       alert('This change will impact the slots. Please make sure that adjust day wise slots accordingly');

       
            $("#dailyWeeks").hide();
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

    /*
    function validateForm()
    {
        var isSubmit = true;
        

        $("#errorMessage").html('');
        $("#errorMsg").hide('');
        var bookingTypeVal = '';
        var paymentTypeVal = '';

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

    */


    /*
        serviceName
        servieDescription
        serviceDuration
        bookingType
        startDate
        endDate
        singleDay


    */

    
function displayNoOfSlots(noOfSlots, existingSlots)
{
   // alert(noOfSlots);
   var timeSlotString = '';
   var totalSlots = parseInt(noOfSlots)+parseInt(existingSlots);
   var initialSlots = parseInt(existingSlots)+0;

    
   for(var i=initialSlots; i < totalSlots; i++)
   {

    
        timeSlotString += '<div class="row" id="slotID'+i+'"><div class="col-md-2"><div class="form-group"><label class="required">Start Time</label><input type="time" name="startTime[]" class="form-control time_input" autocomplete="nope"></div></div><div class="col-md-2"><div class="form-group"><label class="required">End Time</label><input type="time" name="endTime[]" class="form-control time_input" autocomplete="nope"></div></div><div class="col-md-2"><div class="form-group"><label class="required">Seats</label><input type="number" name="seats[]" class="form-control time_input" autocomplete="nope" onChange="checkSeats('+i+');" id="totalSeats'+i+'"></div></div><div class="col-md-1 font11"><div class="form-group"><label>Taken</label><input type="number" name="seatstaken[]" class="form-control time_input" autocomplete="nope" id="takenSeats'+i+'" readonly="true"></div></div><div class="col-md-1 font11"><div class="form-group"><label>Seats</label><input type="number" name="seatsremaining[]" class="form-control time_input" autocomplete="nope" readonly="true" id="remainingSeats'+i+'"><input type="hidden" name="ids[]" class="form-control time_input" autocomplete="nope" value=""></div></div><div class="col-md-2" style="padding-top:28px;"><a href="#" onClick="removeSlot('+i+'); return false;">Remove this slot</a></div></div>';

        $("#moreTimeSlots").html(timeSlotString);
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

function removeSlot(divID)
{
    $("#slotID"+divID).remove();
}

function validateForm()
    {
       var isSubmit = true;

        

        $("#errorMessage").html('');
        $("#errorMessage").hide('');
        var bookingTypeVal = '';
        var paymentTypeVal = '';

        if($("#serviceName").val() == '')
        {
            $("#errorMessage").html('Service name is required');
            $("#errorMessage").show('');
            isSubmit = false;
        }

        if($("#servieDescription").val() == '')
        {
            $("#errorMessage").html('Service description is required');
            $("#errorMessage").show('');
            isSubmit = false;
        }

        if($("#serviceDuration").val() == '')
        {
            $("#errorMessage").html('Service duration is required');
            $("#errorMessage").show('');
            isSubmit = false;
        }

        if($("#serviceDuration").val() == '')
        {
            $("#errorMessage").html('Service duration is required');
            $("#errorMessage").show('');
            isSubmit = false;
        }

        if ($('input[name="bookingType"]:checked').length == 0) {
            $("#errorMessage").html('Booking type is required');
            $("#errorMessage").show('');
            isSubmit = false;
        }
        else{
            bookingTypeVal = $('input[name="bookingType"]:checked').val();
        }

        if(bookingTypeVal == 2)
        {
            if($("#startDate").val() == '')
            {
                $("#errorMessage").html('Start date is required');
                $("#errorMessage").show('');
                isSubmit = false;
            }
            else if($("#endDate").val() == '')
            {
                $("#errorMessage").html('End date is required');
                $("#errorMessage").show('');
                isSubmit = false;   
            }
            else if($("#startDate").val()!='' && $("#endDate").val())
            {
                let startDateStamp = new Date($("#startDate").val());
                let endDateStamp = new Date($("#endDate").val());

                if(startDateStamp > endDateStamp)
                {
                    $("#errorMessage").html('Start date should not be greater than the end date');
                    $("#errorMessage").show('');
                    isSubmit = false;          
                }
            }
        }

        if(bookingTypeVal == 1)
        {
            if($("#singleDay").val() == '')
            {
                $("#errorMessage").html('Date is required');
                $("#errorMessage").show('');
                isSubmit = false;
            }
        }

        if($("#numberOfSlots").val() == '' || $("#numberOfSlots").val() == '0')
        {
            $("#errorMessage").html('No of slots is required');
            $("#errorMessage").show('');
            isSubmit = false;
        }

        if ($('input[name="paymentType"]:checked').length == 0) {
            $("#errorMessage").html('Payment type is required');
            $("#errorMessage").show('');
            isSubmit = false;
        }
        else{
            paymentTypeVal = $('input[name="paymentType"]:checked').val();
        }

        
        if(paymentTypeVal ==2 )
        {
        
            
                if ($('input[name="paymentMethod"]:checked').length == 0) {
                    $("#errorMessage").html('Payment method is required');
                    $("#errorMessage").show('');
                    isSubmit = false;
                }
            
        }
        

        if(isSubmit)
    {
       //alert('added');
       $("#errorMessage").html('');
        $("#errorMessage").hide();

       $.easyAjax({
            url: '{{route('admin.updateBooking')}}',
            container: '#updateBooking',
            type: "POST",
            data: $('#updateBooking').serialize(),
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

function checkSeats(ids)
{
    $("#errorMessage").hide();

    var totalSeats = '';
    var takenSeats = '';
    var remainingSeats = '';

    var totalSeats = $("#totalSeats"+ids).val();
    var takenSeats = $("#takenSeats"+ids).val();
    var remainingSeats = $("#remainingSeats"+ids).val();

    if(takenSeats=='')
    {
        takenSeats = 0;
        $("#takenSeats"+ids).val(takenSeats);
    }
    if(remainingSeats=='')
    {
        remainingSeats = 0;
    }

    var remainingSeats = parseInt(totalSeats) - parseInt(takenSeats);
    


    if(parseInt(remainingSeats)<0)
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Seats taken shout not be greater than the total seats');
    }
    else {
        $("#remainingSeats"+ids).val(remainingSeats);
    }

}

function deactivateSlot(slotID)
{
    var  url = '{{route('admin.deleteSlot')}}';
      var token = "{{ csrf_token() }}";

      $.easyAjax({
            type: 'POST',
            url: url,
            data: {'_token': token, 'slotID': slotID},
            success: function (response) {
                if (response.status == "success") {
                  //  $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                    window.location.reload();
                }
            }
        });

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
