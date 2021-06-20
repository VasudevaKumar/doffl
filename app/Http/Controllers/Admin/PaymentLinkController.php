<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreProjectCategory;
use Auth;
use Illuminate\Support\Facades\DB;




class PaymentLinkController extends AdminBaseController
{
    //

    
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.paymenetLinks.payments';
        $this->pageIcon = 'fa fa-file';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;
        
        $this->paymentLinks = DB::select('
         SELECT
                id,
                randomString,
                amount,
                purpose,
                CASE WHEN(paymentLinkType = 1) THEN "Group" ELSE "Individual" END as `paymentLinkType`,
                customeremail,
                customerphone,
                expiredate,
                CASE WHEN(paypalenabled = 1) THEN "Yes" ELSE "No" END as `paypalenabled`,
                CASE WHEN(rozerpayenabled = 1) THEN "Yes" ELSE "No" END as `rozerpayenabled`,
                CASE WHEN(stripeenabled = 1) THEN "Yes" ELSE "No" END as `stripeenabled`,
                views,
                created_at,
                updated_at,
                deleted_at
               
        FROM
            `payment_links` WHERE company_id = '.$this->company_id.' AND deleted_at IS NULL');

        return view('admin.paymentlinks.index', $this->data);
    }
    
    public function addPaymentLink()
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

         $this->companies = DB::select('
        SELECT
            `companies`.id , 
            `companies`.company_name
        FROM
            `companies` WHERE id = '.$this->company_id.' ');

        $this->pixels = DB::select('
        SELECT
            *
        FROM
            `pixle_config` WHERE created_by =  '.$this->company_id.'');

       return view('admin.paymentlinks.addPaymentLink', $this->data);
    }

    public function savePaymentLink(Request $request)
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $company_name = '';

        $amount = '';
        $purpose = '';
        $PaymentLinkType = '';
        $customeremail = '';
        $customerphone = '';
        $expiredate = '';
        $paypal = '';
        $rozarpay = '';


        $randomstring = '';
        array_map(function($value) use(&$randomstring){
            $randomstring.=mt_rand(0, 9);
        }, range(0,13));

        if(isset($_REQUEST['company_name']))
        {
            $company_name = $_REQUEST['company_name'];
        }

        if(isset($_REQUEST['amount']))
        {
            $amount = $_REQUEST['amount'];
        }

        if(isset($_REQUEST['purpose']))
        {
            $purpose = addslashes($_REQUEST['purpose']);
        }

        if(isset($_REQUEST['PaymentLinkType']))
        {
            $PaymentLinkType = $_REQUEST['PaymentLinkType'];
        }

        if(isset($_REQUEST['customeremail']))
        {
            $customeremail = addslashes($_REQUEST['customeremail']);
        }

        if(isset($_REQUEST['customerphone']))
        {
            $customerphone = addslashes($_REQUEST['customerphone']);
        }

        if(isset($_REQUEST['expiredate']))
        {
            $expiredate = $_REQUEST['expiredate'];
        }

        if(isset($_REQUEST['paypal']))
        {
            $paypal = $_REQUEST['paypal'];
        }

        if(isset($_REQUEST['rozarpay']))
        {
            $rozarpay = $_REQUEST['rozarpay'];
        }
        if(isset($_REQUEST['stripe']))
        {
            $stripe = $_REQUEST['stripe'];
        }

        if(isset($_REQUEST['pixels']))
        {
            $pixels = $_REQUEST['pixels'];
        }


        if($randomstring!='')
        {
            $paymentLinkID = DB::table('payment_links')->insertGetId(
                [
                    'company_id'=> $company_name,
                    'randomstring'=> $randomstring,
                    'amount'=> $amount, 
                    'purpose' => $purpose,
                    'paymentLinkType'=>$PaymentLinkType,
                    'customeremail' => $customeremail,
                    'customerphone'=>$customerphone,
                    'expiredate'=>$expiredate,
                    'paypalenabled'=>$paypal,
                    'rozerpayenabled'=>$rozarpay,
                    'stripeenabled'=>$stripe,
                    'created_by'=>$this->user_id
                ]
            );
        }


        if(!empty($pixels))
        {
            $deleteQuery = DB::delete('DELETE FROM paymentlink_pixels where paymentlinkID = "'.$paymentLinkID.'" ');
            foreach($pixels as $key=>$value)
            {
                $pixelID = DB::table('paymentlink_pixels')->insertGetId(
                ['paymentlinkID'=> $paymentLinkID , 'pixel' => $value]);
            }
        }


        $returnData = array();
        return Reply::successWithData(__('messages.PaymentLink.paymentLinkInserted'),['data' => $returnData]);
        exit();
    

    }

    function editPaymentLink($id)
    {
        
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $this->paymentlinks = DB::select('
                                SELECT
                                    *
                                FROM
                                    `payment_links` a                    
                                WHERE 
                                    id = '.$id.' ');
            



        $this->pixels = DB::select('
        SELECT
            *
        FROM
            `pixle_config` WHERE created_by =  '.$this->company_id.'');


        $this->existingpixels = DB::select('
                                SELECT 
                                    a.pixel 
                                FROM 
                                    `paymentlink_pixels` a
                                  JOIN 
                                    `payment_links` b 
                                   ON   
                                    a.paymentlinkID = b.id
                                  WHERE 
                                    b.id = '.$id.' ' );

        return view('admin.paymentlinks.editPaymentLink', $this->data);

    }

    function viewbooking($id)
    {
        
        $this->bookingDetails = DB::select('
                                SELECT
                                   a.name,
                                   a.email,
                                   a.phone,
                                   a.specialnote,
                                   a.slot,
                                   a.trasactionID,
                                   a.trasactionStatus,
                                   a.paymentType,
                                   b.startTime,
                                   b.endTime
                                FROM
                                    `bookingdetails` a 
                                LEFT JOIN 
                                    `bookingslots` b
                                ON 
                                    a.slot = b.id
                                WHERE 
                                    a.bookingID = "'.$id.'" ');

        return view('admin.bookings.viewbooking', $this->data);

    }


    

    function updatePaymentLink(Request $request)
    {
        // return $request;

        $user = Auth::user();
        $this->user_id     = $user->id;
        $company_name = '';

        $amount = '';
        $purpose = '';
        $PaymentLinkType = '';
        $customeremail = '';
        $customerphone = '';
        $expiredate = '';
        $paypal = '';
        $rozarpay = '';
        $stripe ='';

        $randomstring = '';
        array_map(function($value) use(&$randomstring){
            $randomstring.=mt_rand(0, 9);
        }, range(0,13));

        if(isset($_REQUEST['company_name']))
        {
            $company_name = $_REQUEST['company_name'];
        }

        if(isset($_REQUEST['amount']))
        {
            $amount = $_REQUEST['amount'];
        }

        if(isset($_REQUEST['purpose']))
        {
            $purpose = addslashes($_REQUEST['purpose']);
        }

        if(isset($_REQUEST['PaymentLinkType']))
        {
            $PaymentLinkType = $_REQUEST['PaymentLinkType'];
        }

        if(isset($_REQUEST['customeremail']))
        {
            $customeremail = addslashes($_REQUEST['customeremail']);
        }

        if(isset($_REQUEST['customerphone']))
        {
            $customerphone = addslashes($_REQUEST['customerphone']);
        }

        if($PaymentLinkType == 1)
        {
            $customeremail = NULL;
            $customerphone = NULL;
        }
        if(isset($_REQUEST['expiredate']))
        {
            $expiredate = $_REQUEST['expiredate'];
        }

        if(isset($_REQUEST['paypal']))
        {
            $paypal = $_REQUEST['paypal'];
        }

        if(isset($_REQUEST['rozarpay']))
        {
            $rozarpay = $_REQUEST['rozarpay'];
        }

        if(isset($_REQUEST['stripe']))
        {
            $stripe = $_REQUEST['stripe'];
        }


        if(isset($_REQUEST['paymentLinkID']))
        {
            $paymentLinkID = $_REQUEST['paymentLinkID'];
        }


        if(isset($_REQUEST['pixels']))
        {
            $pixels = $_REQUEST['pixels'];
        }


        $modifiedDate = date('Y-m-d h:i:S');

        $this->result = DB::update("UPDATE 
                                            `payment_links` 
                                        SET
                                            amount = :amount,
                                            purpose = :purpose,
                                            paymentLinkType = :paymentLinkType,
                                            customeremail = :customeremail,
                                            customerphone =:customerphone,
                                            expiredate = :expiredate,
                                            paypalenabled =:paypalenabled,
                                            rozerpayenabled =:rozerpayenabled,
                                            stripeenabled =:stripeenabled,
                                            updated_at =:updated_at
                                        WHERE 
                                            id = :id", 
                                        [
                                            "amount" =>$amount,
                                            "purpose" => $purpose,
                                            "paymentLinkType" => $PaymentLinkType,
                                            "customeremail" => $customeremail,
                                            "customerphone" => $customerphone,
                                            "expiredate" => $expiredate,
                                            "paypalenabled" => $paypal,
                                            "rozerpayenabled" => $rozarpay,
                                            "stripeenabled" => $stripe,
                                            "updated_at" => $modifiedDate,
                                            "id" => $paymentLinkID]
                                    ); 

        
        $deleteQuery = DB::delete('DELETE FROM paymentlink_pixels where paymentlinkID = "'.$paymentLinkID.'" ');

        if(!empty($pixels))
        {
            
            foreach($pixels as $key=>$value)
            {
                $pixelID = DB::table('paymentlink_pixels')->insertGetId(
                ['paymentlinkID'=> $paymentLinkID , 'pixel' => $value]);
            }
        }


        $returnData = array();
        return Reply::successWithData(__('messages.PaymentLink.paymentLinkUpdated'),['data' => $returnData]);
        exit();


    }
    
    public function deletepaymentLink(Request $request)
    {   
        $id = $request->id;

        $affected = DB::table('payment_links')
        ->where('id', $id)
        ->update(['deleted_at' => \Carbon\Carbon::now()]);
        
        $returnData = array();
        return Reply::successWithData(__('messages.PaymentLink.paymentLinkBooking'),['data' => $returnData]);
        exit();


    }
        
    public function siteSetting(Request $request)
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $this->plSettings = DB::select('
        SELECT
            *
        FROM
            `paymentlinksitesetting` WHERE company_id =  '.$this->company_id.'');

        
    /*
        $this->existingpixels = DB::select('
                                SELECT 
                                    a.pixel 
                                FROM 
                                    `paymentlinksitesetting_pixel` a
                                  JOIN 
                                    `paymentlinksitesetting` b 
                                   ON   
                                    a.settingID = b.id
                                  WHERE 
                                    b.company_id = '.$this->company_id.'' );

       
        
        $this->pixels = DB::select('
        SELECT
            *
        FROM
            `pixle_config` WHERE created_by =  '.$this->company_id.'');
        */

        return view('admin.paymentlinks.addplSetting', $this->data);
    }

    
    function saveSetting(Request $request)
    {
        // return $request;        
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        
        $buttonColor = '';


        

        if(isset($_REQUEST['buttonColor']))
        {
            $buttonColor = $_REQUEST['buttonColor'];
        }
        
        if(isset($_REQUEST['textColor']))
        {
            $textColor = $_REQUEST['textColor'];
        }
        



        $deleteQuery = DB::delete('DELETE FROM paymentlinksitesetting where company_id = "'.$this->company_id.'" ');


        $settingID = DB::table('paymentlinksitesetting')->insertGetId(
            ['company_id'=> $this->company_id ,  'buttonColor' => $buttonColor, 'textcolor' => $textColor]);

        
        $returnData = array();
        return Reply::successWithData(__('messages.PaymentLink.paymentLinkSiteInserted'),['data' => $returnData]);
        exit();

    }


    function updateSetting(Request $request)
    {

         //  return $request;

        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        
        $buttonColor = '';
        
        $settingID = '';
        $hdnSettingID = '';


        if(isset($_REQUEST['buttonColor']))
        {
            $buttonColor = $_REQUEST['buttonColor'];
        }

         if(isset($_REQUEST['hdnSettingID']))
        {
            $settingID = $_REQUEST['hdnSettingID'];
        }
       
       if(isset($_REQUEST['textColor']))
        {
            $textColor = $_REQUEST['textColor'];
        }


        $modifiedDateTime = date('Y-m-d h:i:s');


        $this->result = DB::update("UPDATE `paymentlinksitesetting` 
                                                        SET 
                                                        company_id = :company_id ,
                                                        buttonColor = :buttonColor,
                                                        textColor =:textColor,
                                                        updated_at = :updated_at
                                                        WHERE 
                                                            id = :id", [
                                                                            "company_id" =>$this->company_id, 
                                                                            "buttonColor"=>$buttonColor,
                                                                            'textColor' => $textColor,
                                                                            'updated_at'=> $modifiedDateTime,
                                                                            "id" => $settingID]); 

        /*
        if(!empty($pixels))
        {
            $deleteQuery = DB::delete('DELETE FROM paymentlinksitesetting_pixel where settingID = "'.$settingID.'" ');
            foreach($pixels as $key=>$value)
            {
                $pixelID = DB::table('paymentlinksitesetting_pixel')->insertGetId(
                ['settingID'=> $settingID , 'pixel' => $value]);
            }
        }
    */

        $returnData = [];
        return Reply::successWithData(__('messages.PaymentLink.paymentLinkSiteUpdated'), $returnData);


    }

    function viewpaymentLink($id)
    {
        
        $this->paymentlinkLeads = DB::select('
                                SELECT
                                   a.name,
                                   a.email,
                                   a.phone,
                                   a.trasactionID,
                                   a.trasactionStatus,
                                   a.paymentType
                                   
                                FROM
                                    `paymentlinkleads` a 
                                WHERE 
                                    a.paymentLinkID = "'.$id.'" ');

        return view('admin.paymentlinks.viewpaymentLink', $this->data);

    }


    
    


}                         
