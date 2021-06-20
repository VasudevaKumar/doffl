@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-md-12">
                <div class="vtabs customvtab m-t-10">
                    @include('sections.admin_setting_menu')
                </div>
            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('modules.Recruit.mediaLinks')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <?php if(count($mediaLinks) ==0) { ?> 
                    <div class="panel-body">
                        {!! Form::open(['id'=>'createMediaLink','class'=>'ajax-form','method'=>'POST']) !!}
                            <div class="form-body">


                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label >@lang('modules.frontCms.enterFacebookLink')</label>
                                             <input type="text" name="facebookLink" id="facebookLink" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>


                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label >@lang('modules.frontCms.enterTwitterLink')</label>
                                             <input type="text" name="twitterLink" id="twitterLink" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label >@lang('modules.frontCms.enterInstagramLink')</label>
                                             <input type="text" name="instramLink" id="instramLink" class="form-control" autocomplete="nope" 
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>

                                

                                    </div>
                                   <!--/span-->
                                </div>
                             
                                </div>

                                   <!--/span-->
                                </div>

                            </div>
                            <div class="form-actions" style="margin-left:30px;">
                                <button type="submit" id="save-form" class="btn btn-success" onClick="validateForm(); return false;"> <i class="fa fa-check"></i> @lang('app.save')</button>

                                <div id ="errorMsg" name="errorMsg" class="alert-danger" style="display:none; padding:8px; margin-top: 5px; ">
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <?php } else { ?>
                        <div class="panel-body">
                        {!! Form::open(['id'=>'editMediaLink','class'=>'ajax-form','method'=>'POST']) !!}
                            <div class="form-body">


                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label >@lang('modules.frontCms.enterFacebookLink')</label>
                                             <input type="text" name="facebookLink" id="facebookLink" class="form-control"
                                                   autocomplete="nope" value="<?php echo stripslashes($mediaLinks[0]->facebook );?>">
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>


                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label >@lang('modules.frontCms.enterTwitterLink')</label>
                                             <input type="text" name="twitterLink" id="twitterLink" class="form-control"
                                                   autocomplete="nope" value="<?php echo stripslashes($mediaLinks[0]->twitter);?>">
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label >@lang('modules.frontCms.enterInstagramLink')</label>
                                             <input type="text" name="instramLink" id="instramLink" class="form-control"
                                                   autocomplete="nope" value="<?php echo $mediaLinks[0]->instagram;?>">
                                        </div>
                                    </div>

                                   <!--/span-->
                                </div>

                                


                               

                                



                                
                                


                                    </div>
                                   <!--/span-->
                                </div>
                             
                                </div>

                                   <!--/span-->
                                </div>

                            </div>
                            <div class="form-actions" style="margin-left:30px;">
                                <input type="hidden" name="hdnSettingID" id="hdnSettingID" value="<?php echo $mediaLinks[0]->id;?>">
                                <button type="submit" id="save-form" class="btn btn-success" onClick="validateEditForm(); return false;"> <i class="fa fa-check"></i> @lang('app.save')</button>

                                <div id ="errorMsg" name="errorMsg" class="alert-danger" style="display:none; padding:8px; margin-top: 5px; ">

                            </div>
                        {!! Form::close() !!}
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>    <!-- .row -->



@endsection

<div id="myModal" class="modal">

                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <p><div id="dynamicContent">Some text in the Modal..</div></p>
                  </div>

                </div>
                

@push('footer-script')

<script src="{{ asset('kbSettings/js/jscolor.js') }}"></script>

<script type="text/javascript">
    
    function validateForm()
    {
        var isSubmit = true;
        

        $("#errorMsg").html('');
        $("#errorMsg").hide();
        


        if(isSubmit)
        {
       //alert('added');
       $("#errorMsg").html('');
        $("#errorMsg").hide();

       $.easyAjax({
            url: '{{route('admin.recruit.settings.saveMedialinks')}}',
            container: '#createMediaLink',
            type: "POST",
            data: $('#createMediaLink').serialize(),
            file:  true,
            success: function (response) {
                if (response.status == 'success') {
                  
                    // var url = '{{ route('admin.bookings')}}';
                     // location.href = url;
                     $("#errorMessage").show();
                    $("#errorMessage").html(response.message);
                     
                }else{
                    // console.log(response);
                    $("#errorMessage").show();
                    $("#errorMessage").html(response.message);
                }
            }
        });
        


        }



    }

    function validateEditForm()
    {


        var isSubmit = true;
        

        $("#errorMsg").html('');
        $("#errorMsg").hide();
        

        


        if(isSubmit)
        {
       //alert('added');
       $("#errorMsg").html('');
        $("#errorMsg").hide();

       $.easyAjax({
            url: '{{route('admin.recruit.settings.updateMedialinks')}}',
            container: '#editMediaLink',
            type: "POST",
            data: $('#editMediaLink').serialize(),
            file:  true,
            success: function (response) {
                if (response.status == 'success') {
                  
                    // var url = '{{ route('admin.bookings')}}';
                     // location.href = url;
                     $("#errorMessage").show();
                    $("#errorMessage").html(response.message);
                     
                }else{
                    // console.log(response);
                    $("#errorMessage").show();
                    $("#errorMessage").html(response.message);
                }
            }
        });
        


        }


    }


var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
/*
btn.onclick = function() {
  modal.style.display = "block";
}
*/  

function shareUrl(company_id)
{
    var urlString = 'https://'+window.location.hostname+'/support/index.php?companyID='+company_id;
    document.getElementById("dynamicContent").innerHTML = urlString;
    modal.style.display = "block";

}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>


<style type="text/css">
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 35%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
  
</style>


@endpush

<style type="text/csss">


</style>
