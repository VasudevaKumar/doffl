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
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.paymenetLinks.payments')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->

        <!-- /.breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        <label class="control-label">
            <a href="{{ route('admin.addPaymentLink') }}" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.Paymentlinks.addPaymentLink')</a>
        </label>
        </div>

    </div>
@endsection

@section('content')

<div class="row">
    {!! Form::open(['id'=>'managePaymentLinks','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="col-md-12">
            <div class="white-box">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>@lang('modules.Paymentlinks.amount')</th>
                            <th>@lang('modules.Paymentlinks.purpose')</th>
                            <th>@lang('modules.Paymentlinks.linkType')</th>
                            <th>@lang('modules.Paymentlinks.expiredate')</th>
                            <th>@lang('modules.Paymentlinks.paypalenabled')</th>
                            <th>@lang('modules.Paymentlinks.rozerpayenabled')</th>
                            <th>@lang('modules.Paymentlinks.stripeenabled')</th>
                            <th>@lang('modules.Paymentlinks.views')</th>
                            <th>@lang('modules.Paymentlinks.createdDate')</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($paymentLinks as $key=>$paymentLink)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $paymentLink->amount }}</td>
                                <td>{{ $paymentLink->purpose }}</td>
                                <td>{{ $paymentLink->paymentLinkType }}</td>
                                <td>{{ $paymentLink->expiredate }}</td>
                                <td>{{ $paymentLink->paypalenabled }}</td>
                                <td>{{ $paymentLink->rozerpayenabled }}</td>
                                <td>{{ $paymentLink->stripeenabled }}</td>
                                <td>{{ $paymentLink->views }}</td>
                                <td>{{ $paymentLink->created_at }}</td>
                                <td><a href="#" onclick="shareUrl('<?php echo $paymentLink->randomString;?>'); false;">Share</a></td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4 float-left">
                                        <button type="button" class="btn btn-default btn-sm" onClick="editpaymentLink({{ $paymentLink->id }})" title="edit">
                                              <span class="glyphicon glyphicon-edit"></span> 
                                        </button>

                                        </div>

                                        <div class="col-md-4 float-left">

                                        <button type="button" class="btn btn-default btn-sm" onClick="deletepaymentLink({{ $paymentLink->id }})" title="delete">
                                              <span class="glyphicon glyphicon-remove-sign"></span>
                                        </button>

                                        </div>

                                        <div class="col-md-4 float-left">

                                        <button type="button" class="btn btn-default btn-sm" onClick="viewpaymentLink({{ $paymentLink->id }})" title="view list">
                                              <span class="glyphicon glyphicon-user"></span>
                                        </button>


                                        


                                        </div>



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
                                            <div class="title m-b-15">No pyament link found</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       
        {!! Form::close() !!}

                 

    </div>
    <!-- .row -->


@endsection



<!-- The Modal -->
                <div id="myModal" class="modal">

                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <p><div id="dynamicContent">Some text in the Modal..</div></p>
                  </div>

                </div>

@push('footer-script')
<script type="text/javascript">
function editpaymentLink(id)
{
      var url = '{{ route('admin.editPaymentLink', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
}

function viewpaymentLink(id)
{
      var url = '{{ route('admin.viewpaymentLink', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
}


function deletepaymentLink(id)
{
        /*
       var url = '{{ route('admin.deleteBooking', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
       */

       var  url = '{{route('admin.deletepaymentLink')}}';
      var token = "{{ csrf_token() }}";

      $.easyAjax({
            type: 'POST',
            url: url,
            data: {'_token': token, 'id': id},
            success: function (response) {
                if (response.status == "success") {
                       window.location.reload();
                }
            }
        });

      
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

function shareUrl(randomstring)
{
    var urlString = 'https://'+window.location.hostname+'/checkout?mid='+randomstring;
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

