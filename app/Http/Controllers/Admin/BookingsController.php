<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreProjectCategory;
use Auth;
use Illuminate\Support\Facades\DB;




class BookingsController extends AdminBaseController
{
    //

    
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.bookingsSettings.bookings';
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

        $this->bookings = DB::select('
        SELECT
                id,
                randomstring,
                serviceName,
                serviceDescription,
                serviceDuration,
                CASE WHEN(bookingType = 1) THEN "Once" ELSE "Daily" END as `bookingTypeInfo`,
                DATE(bookingDate) bookingDate,
                DATE(bookingStartDate) bookingStartDate,
                DATE(bookingEndDate) bookingEndDate,
                NoOfSlots,
                CASE WHEN(paymentType = 1) THEN "Free" ELSE "Paid" END  as `paymentTypeInfo`,
                CASE WHEN(paymentMethod = 1) THEN "Online" ELSE "Local" END  as `paymentMethodInfo`,
                rememberAfter,
                CASE 
                    WHEN(rememberType = 1) THEN "Minutes" 
                    WHEN(rememberType = 2) THEN "Hours" 
                    ELSE "Daily" 
                END
                    as `rememberTypeInfo`,
                    created_date,
                    views
                
        FROM
            `bookings` WHERE company_id = '.$this->company_id.' AND deleted_at IS NULL');
        

        

        return view('admin.bookings.index', $this->data);
    }
    
    public function addBooking()
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

        return view('admin.bookings.addBooking', $this->data);
    }

    public function saveBooking(Request $request)
    {
        $user = Auth::user();
        $this->user_id     = $user->id;

       // return $request;


        $serviceName = '';
        $servieDescription = '';
        $serviceDuration = '';
        $bookingType = '';
        $startDate = '';
        $endDate = '';
        $singleDay = '';
        $dailyWeek = '';
        $dailyWeekStatus = '';
        $numberOfSlots = '';
        $startTime = '';
        $endTime = '';
        $seats = '';
        $paymentType = '';
        $paymentMethod = '';
        $rememberAfter = '';
        $rememberAfterValue = '';
        $paymentAmount = '';

        $weeklyStatus = array();
        $slotsArray = array();
        $company_name = '';

        $randomstring = '';
        array_map(function($value) use(&$randomstring){
            $randomstring.=mt_rand(0, 9);
        }, range(0,13));

        if(isset($_REQUEST['company_name']))
        {
            $company_name = $_REQUEST['company_name'];
        }

        if(isset($_REQUEST['serviceName']))
        {
            $serviceName = $_REQUEST['serviceName'];
        }

        if(isset($_REQUEST['servieDescription']))
        {
            $servieDescription = $_REQUEST['servieDescription'];
        }

        if(isset($_REQUEST['serviceDuration']))
        {
            $serviceDuration = $_REQUEST['serviceDuration'];
        }

        if(isset($_REQUEST['bookingType']))
        {
            $bookingType = $_REQUEST['bookingType'];
        }

        if(isset($_REQUEST['startDate']))
        {
            $startDate = $_REQUEST['startDate'];
        }

        if(isset($_REQUEST['endDate']))
        {
            $endDate = $_REQUEST['endDate'];
        }

        if(isset($_REQUEST['singleDay']))
        {
            $singleDay = $_REQUEST['singleDay'];
        }

        if(isset($_REQUEST['singleDay']))
        {
            $singleDay = $_REQUEST['singleDay'];
        }

        if(isset($_REQUEST['numberOfSlots']))
        {
            $numberOfSlots = $_REQUEST['numberOfSlots'];
        }

        if(isset($_REQUEST['paymentType']))
        {
            $paymentType = $_REQUEST['paymentType'];
        }

        if(isset($_REQUEST['paymentMethod']))
        {
            $paymentMethod = $_REQUEST['paymentMethod'];
        }

        if(isset($_REQUEST['rememberAfter']))
        {
            $rememberAfter = $_REQUEST['rememberAfter'];
        }
        if(isset($_REQUEST['rememberAfterValue']))
        {
            $rememberAfterValue = $_REQUEST['rememberAfterValue'];
        }
        if(isset($_REQUEST['paymentAmount']))
        {
            $paymentAmount = $_REQUEST['paymentAmount'];
        }

        
        if($rememberAfterValue == 1 && $rememberAfter < 30)
        {
             $rememberAfter = 30;
        }


        if($paymentType == 1)
        {
            $paymentAmount = 0;
        }
        
        


        if(!empty($_REQUEST['dailyWeek']))
        {
            $countDaily = count($_REQUEST['dailyWeek']);

            for($i=0; $i<$countDaily; $i++)
            {
                $weeklyStatus[$_REQUEST['dailyWeek'][$i]] = $_REQUEST['dailyWeekStatus'][$i];
            }
        }

        if(!empty($_REQUEST['startTime']))
        {
            $countSlots = count($_REQUEST['startTime']);

            for($i=0; $i<$countSlots; $i++)
            {
                $slotsArray[$i]['startTime'] = $_REQUEST['startTime'][$i];
                $slotsArray[$i]['endTime'] = $_REQUEST['endTime'][$i];
                $slotsArray[$i]['seats'] = $_REQUEST['seats'][$i];
            }
        }


        if(isset($_REQUEST['pixels']))
        {
            $pixels = $_REQUEST['pixels'];
        }




      //  return $weeklyStatus;
      //  return $slotsArray;
        /*
        echo '<pre>';
        print_r($slotsArray);
        echo '</pre>';
        exit();
        */

        if($randomstring!='')
        {
            $bookingID = DB::table('bookings')->insertGetId(
                [
                    'company_id' => $company_name,
                    'serviceName'=>$serviceName,
                    'randomstring'=> $randomstring,
                    'serviceDescription'=> $servieDescription, 
                    'serviceDuration' => $serviceDuration,
                    'bookingType'=>$bookingType,
                    'bookingDate' => $singleDay,
                    'bookingStartDate'=>$startDate,
                    'bookingEndDate'=>$endDate,
                    'NoOfSlots'=>$numberOfSlots,
                    'paymentType'=>$paymentType,
                    'paymentMethod'=>$paymentMethod,
                    'rememberType'=>$rememberAfter,
                    'rememberAfter'=>$rememberAfterValue,
                    'paymentAmount' => $paymentAmount,
                    'created_by'=>$this->user_id
                ]
            );

            if($bookingType == 2)
            {
            if(!empty($weeklyStatus))
            {
            foreach($weeklyStatus as $key=>$value)
            {    if($value !='')
                    {
                        $result = DB::table('bookingweeklyavailability')->insertGetId(
                            [
                                'bookingID'=> $bookingID , 
                                'day' => $key,
                                'isAvailable'=>$value
                            ]
                        );
                    }
                }
            }
        }
            
            if($bookingType == 1)
            {
                if(!empty($slotsArray))
                {
                    foreach($slotsArray as $key=>$value)
                    {    if($value['startTime'] !='')
                            {
                                $result = DB::table('bookingslots')->insertGetId(
                                    [
                                        'bookingID'=> $bookingID , 
                                        'bookingDate'=> $singleDay,
                                        'startTime' => $value['startTime'],
                                        'endTime'=> $value['endTime'],
                                        'seats' => $value['seats'],
                                        'seatsremaining' => $value['seats']
                                    ]
                                );
                            }
                        }
                }
            }

            if($bookingType == 2)
            {
                while (strtotime($startDate) <= strtotime($endDate)) {
                    


                    if(!empty($slotsArray))
                {
                    foreach($slotsArray as $key=>$value)
                    {    if($value['startTime'] !='')
                            {
                                $result = DB::table('bookingslots')->insertGetId(
                                    [
                                        'bookingID'=> $bookingID , 
                                        'bookingDate'=> $startDate,
                                        'startTime' => $value['startTime'],
                                        'endTime'=> $value['endTime'],
                                        'seats' => $value['seats'],
                                        'seatsremaining' => $value['seats']
                                    ]
                                );
                            }
                        }
                }
                $startDate = date ("Y-m-d", strtotime("+1 days", strtotime($startDate)));

                }
            }
        }


        if(!empty($pixels))
        {
            $deleteQuery = DB::delete('DELETE FROM bookings_pixel where bookingID = "'.$bookingID.'" ');
            foreach($pixels as $key=>$value)
            {
                $pixelID = DB::table('bookings_pixel')->insertGetId(
                ['bookingID'=> $bookingID , 'pixel' => $value]);
            }
        }


        $returnData = array();
        return Reply::successWithData(__('messages.Bookings.bookingInserted'),['data' => $returnData]);
        exit();

    }

    function editBooking($id)
    {
        

         $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;


        $this->bookings = DB::select('
                                SELECT
                                    *
                                FROM
                                    `bookings` a                    
                                WHERE 
                                    id = '.$id.' ');
        

        $this->bookingslots = DB::select('
            SELECT
                *
            FROM
                `bookingslots` a                    
            WHERE 
                bookingID = '.$id.' AND deleted_at IS NULL ORDER BY bookingDate');
        
        $this->bookingweekly = DB::select('
        SELECT
            *
        FROM
            `bookingweeklyavailability` a                    
        WHERE 
            bookingID = '.$id.' ');
        

        $this->seatsTaken = DB::select('
        SELECT sum(seatstaken) as `seatstaken` FROM `bookingslots` WHERE bookingID = '.$id.' ');


        $this->pixels = DB::select('
        SELECT
            *
        FROM
            `pixle_config` WHERE created_by =  '.$this->company_id.'');


        $this->existingpixels = DB::select('
                                SELECT 
                                    a.pixel 
                                FROM 
                                    `bookings_pixel` a
                                  JOIN 
                                    `bookings` b 
                                   ON   
                                    a.bookingID = b.id
                                  WHERE 
                                    b.id = '.$id.' ' );


        return view('admin.bookings.editBooking', $this->data);

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
                                    a.bookingID = "'.$id.'" 
                                ORDER BY 
                                    trasactionStatus DESC, 
                                    paymentType');

        return view('admin.bookings.viewbooking', $this->data);

    }


    

    function updateBooking(Request $request)
    {
        // return $request;

        $user = Auth::user();
        $this->user_id     = $user->id;
     
        
       // return $request;

        $serviceName = '';
        $servieDescription = '';
        $serviceDuration = '';
        $bookingType = '';
        $startDate = '';
        $endDate = '';
        $singleDay = '';
        $dailyWeek = '';
        $dailyWeekStatus = '';
        $numberOfSlots = '';
        $startTime = '';
        $endTime = '';
        $seats = '';
        $paymentType = '';
        $paymentMethod = '';
        $rememberAfter = '';
        $rememberAfterValue = '';

        $weeklyStatus = array();
        $slotsArray = array();
        $bookingID = '';
        $paymentAmount = '';


        if(isset($_REQUEST['serviceName']))
        {
            $serviceName = $_REQUEST['serviceName'];
        }

        if(isset($_REQUEST['servieDescription']))
        {
            $servieDescription = $_REQUEST['servieDescription'];
        }

        if(isset($_REQUEST['serviceDuration']))
        {
            $serviceDuration = $_REQUEST['serviceDuration'];
        }

        if(isset($_REQUEST['bookingType']))
        {
            $bookingType = $_REQUEST['bookingType'];
        }

        if(isset($_REQUEST['startDate']))
        {
            $startDate = $_REQUEST['startDate'];
        }

        if(isset($_REQUEST['endDate']))
        {
            $endDate = $_REQUEST['endDate'];
        }

        if(isset($_REQUEST['singleDay']))
        {
            $singleDay = $_REQUEST['singleDay'];
        }

        if($bookingType == 1)
        {
            $startDate = NULL;
            $endDate = NULL;
        }

        if($bookingType == 2)
        {
            $singleDay = NULL;
        }


        if(isset($_REQUEST['singleDay']))
        {
            $singleDay = $_REQUEST['singleDay'];
        }

        if(isset($_REQUEST['numberOfSlots']))
        {
            $numberOfSlots = $_REQUEST['numberOfSlots'];
        }

        if(isset($_REQUEST['paymentType']))
        {
            $paymentType = $_REQUEST['paymentType'];
        }

        if(isset($_REQUEST['paymentMethod']))
        {
            $paymentMethod = $_REQUEST['paymentMethod'];
        }

        if(isset($_REQUEST['rememberAfter']))
        {
            $rememberAfter = $_REQUEST['rememberAfter'];
        }
        if(isset($_REQUEST['rememberAfterValue']))
        {
            $rememberAfterValue = $_REQUEST['rememberAfterValue'];
        }

        if(isset($_REQUEST['bookingID']))
        {
            $bookingID = $_REQUEST['bookingID'];
        }




        if(!empty($_REQUEST['dailyWeek']))
        {
            $countDaily = count($_REQUEST['dailyWeek']);

            for($i=0; $i<$countDaily; $i++)
            {
                $weeklyStatus[$_REQUEST['dailyWeek'][$i]] = $_REQUEST['dailyWeekStatus'][$i];
            }
        }

        if(!empty($_REQUEST['startTime']))
        {
            $countSlots = count($_REQUEST['startTime']);

            for($i=0; $i<$countSlots; $i++)
            {
                $slotsArray[$i]['startTime'] = $_REQUEST['startTime'][$i];
                $slotsArray[$i]['endTime'] = $_REQUEST['endTime'][$i];
                $slotsArray[$i]['seats'] = $_REQUEST['seats'][$i];
                $slotsArray[$i]['seatstaken'] = $_REQUEST['seatstaken'][$i];
                $slotsArray[$i]['seatsremaining'] = $_REQUEST['seatsremaining'][$i];
                $slotsArray[$i]['id'] = $_REQUEST['ids'][$i];
            }
        }

        if(isset($_REQUEST['paymentAmount']))
        {
            $paymentAmount = $_REQUEST['paymentAmount'];
        }

       
        if($paymentType == 1)
        {
            $paymentAmount = 0;
        }
       
       if(isset($_REQUEST['pixels']))
        {
            $pixels = $_REQUEST['pixels'];
        }

        if($rememberAfterValue == 1 && $rememberAfter < 30)
        {
             $rememberAfter = 30;
        }


        $this->result = DB::update("UPDATE 
                                            `bookings` 
                                        SET
                                            serviceName = :serviceName,
                                            serviceDescription = :serviceDescription,
                                            serviceDuration = :serviceDuration,
                                            bookingType = :bookingType,
                                            bookingDate =:bookingDate,
                                            bookingStartDate = :bookingStartDate,
                                            bookingEndDate =:bookingEndDate,
                                            NoOfSlots =:NoOfSlots,
                                            paymentType =:paymentType,
                                            paymentMethod =:paymentMethod,
                                            rememberType =:rememberType,
                                            rememberAfter =:rememberAfter,
                                            paymentAmount =:paymentAmount
                                        WHERE 
                                            id = :id", 
                                        [
                                            "serviceName" =>$serviceName,
                                            "serviceDescription" => $servieDescription,
                                            "serviceDuration" => $serviceDuration,
                                            "bookingType" => $bookingType,
                                            "bookingDate" => $singleDay,
                                            "bookingStartDate" => $startDate,
                                            "bookingEndDate" => $endDate,
                                            "NoOfSlots" => $numberOfSlots,
                                            "paymentType" => $paymentType,
                                            "paymentMethod" =>$paymentMethod,
                                            "rememberType" => $rememberAfter,
                                            "rememberAfter" => $rememberAfterValue,
                                            "paymentAmount" => $paymentAmount,
                                            "id" => $bookingID]
                                    ); 

            
            $this->result = DB::delete("DELETE FROM bookingweeklyavailability WHERE bookingID = ? " , ["".$bookingID.""]);
            
            /*
            $this->result = DB::delete("DELETE FROM bookingslots WHERE bookingID = ? " , ["".$bookingID.""]);
            */


            if(!empty($weeklyStatus) && ($bookingType == 2))
            {
            foreach($weeklyStatus as $key=>$value)
            {    if($value !='')
                    {
                        $result = DB::table('bookingweeklyavailability')->insertGetId(
                            [
                                'bookingID'=> $bookingID , 
                                'day' => $key,
                                'isAvailable'=>$value
                            ]
                        );
                    }
                }
            }
            

            if($bookingType == 1)
            {
                if(!empty($slotsArray))
                {
                    foreach($slotsArray as $key=>$value)
                    {
                            if($value['id'] !='')
                            {

                                $this->result = DB::update("UPDATE 
                                            `bookingslots` 
                                        SET
                                          
                                            startTime = :startTime,
                                            endTime = :endTime,
                                            seats = :seats,
                                            seatstaken = :seatstaken,
                                            seatsremaining =:seatsremaining
                                        WHERE 
                                            id = :id", 
                                        [
                                            "startTime" =>$value['startTime'],
                                            "endTime" => $value['endTime'],
                                            "seats" => $value['seats'],
                                            "seatstaken" => $value['seatstaken'],
                                            "seatsremaining" => $value['seatsremaining'],
                                            "id" => $value['id']]
                                    );

                            }
                            else
                            {
                                if($value['startTime'] !='')
                                {
                                    $result = DB::table('bookingslots')->insertGetId(
                                        [
                                            'bookingID'=> $bookingID , 
                                            'bookingDate'=> $singleDay,
                                            'startTime' => $value['startTime'],
                                            'endTime'=> $value['endTime'],
                                            'seats' => $value['seats'],
                                            'seatstaken' => $value['seatstaken'],
                                            'seatsremaining' => $value['seats']
                                        ]
                                    );
                                }
                            }
                        }
                }
            }

            if($bookingType == 2)
            {
                while (strtotime($startDate) <= strtotime($endDate)) {
                    


                    if(!empty($slotsArray))
                {
                    foreach($slotsArray as $key=>$value)
                    {

                        if($value['id'] !='')
                            {

                                $this->result = DB::update("UPDATE 
                                            `bookingslots` 
                                        SET
                                            startTime = :startTime,
                                            endTime = :endTime,
                                            seats = :seats,
                                            seatstaken = :seatstaken,
                                            seatsremaining =:seatsremaining
                                        WHERE 
                                            id = :id", 
                                        [
                                            "startTime" =>$value['startTime'],
                                            "endTime" => $value['endTime'],
                                            "seats" => $value['seats'],
                                            "seatstaken" => $value['seatstaken'],
                                            "seatsremaining" => $value['seatsremaining'],
                                            "id" => $value['id']]
                                    );

                            }
                            else {

                            if($value['startTime'] !='')
                                {
                                    $result = DB::table('bookingslots')->insertGetId(
                                        [
                                            'bookingID'=> $bookingID , 
                                            'bookingDate'=> $startDate,
                                            'startTime' => $value['startTime'],
                                            'endTime'=> $value['endTime'],
                                            'seats' => $value['seats'],
                                            'seatstaken' => $value['seatstaken'],
                                            'seatsremaining' => $value['seatsremaining']
                                        ]
                                    );
                                }
                            }
                        }
                }

                $startDate = date ("Y-m-d", strtotime("+1 days", strtotime($startDate)));
                
                }
            }


          
         

         $deleteQuery = DB::delete('DELETE FROM bookings_pixel where bookingID   = "'.$bookingID.'" ');

        if(!empty($pixels))
        {
            
            foreach($pixels as $key=>$value)
            {
                $pixelID = DB::table('bookings_pixel')->insertGetId(
                ['bookingID'=> $bookingID , 'pixel' => $value]);
            }
        }

        
        $returnData = array();
        return Reply::successWithData(__('messages.Bookings.BookingUpdated'),['data' => $returnData]);
        exit();


    }
    
    public function deleteBooking(Request $request)
    {   
        $id = $request->id;

        $affected = DB::table('bookings')
        ->where('id', $id)
        ->update(['deleted_at' => \Carbon\Carbon::now()]);
        
        $returnData = array();
        return Reply::successWithData(__('messages.Bookings.DeleteBooking'),['data' => $returnData]);
        exit();


    }

    public function deleteSlot(Request $request)
    {   
        $id = $request->slotID;

        $affected = DB::table('bookingslots')
        ->where('id', $id)
        ->update(['deleted_at' => \Carbon\Carbon::now()]);
        
        $returnData = array();
        return Reply::successWithData(__('messages.Bookings.DeleteSlot'),['data' => $returnData]);
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
            `bookingsitesetting` WHERE company_id =  '.$this->company_id.'');

        
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

        return view('admin.bookings.addplSetting', $this->data);
    }

    
    function saveSetting(Request $request)
    {
        // return $request;        
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        
        $calendarbackground = '';
        $highlightedbackground = '';
         $calendertextcolor = '';
         $buttonbackground = '';
         $buttontextcolor = '';


        

        if(isset($_REQUEST['calendarbackground']))
        {
            $calendarbackground = $_REQUEST['calendarbackground'];
        }

        if(isset($_REQUEST['highlightedbackground']))
        {
            $highlightedbackground = $_REQUEST['highlightedbackground'];
        }

        if(isset($_REQUEST['calendertextcolor']))
        {
            $calendertextcolor = $_REQUEST['calendertextcolor'];
        }

        if(isset($_REQUEST['buttonbackground']))
        {
            $buttonbackground = $_REQUEST['buttonbackground'];
        }

        if(isset($_REQUEST['buttontextcolor']))
        {
            $buttontextcolor = $_REQUEST['buttontextcolor'];
        }

        if(isset($_REQUEST['heighlightedtextcolor']))
        {
            $heighlightedtextcolor = $_REQUEST['heighlightedtextcolor'];
        }
        
        
        



        $deleteQuery = DB::delete('DELETE FROM bookingsitesetting where company_id = "'.$this->company_id.'" ');


        $settingID = DB::table('bookingsitesetting')->insertGetId(
            ['company_id'=> $this->company_id ,  'calendarbackground' => $calendarbackground, 'highlightedbackground'=>$highlightedbackground , 'calendertextcolor'=>$calendertextcolor , 'buttonbackground'=>$buttonbackground, 'buttontextcolor'=>$buttontextcolor, 'heighlightedtextcolor'=>$heighlightedtextcolor]);

        
        $returnData = array();
        return Reply::successWithData(__('messages.Bookings.bookingSiteInserted'),['data' => $returnData]);
        exit();

    }


    function updateSetting(Request $request)
    {

         //  return $request;

        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        
         $calendarbackground = '';
         $highlightedbackground = '';
         $calendertextcolor = '';
         $buttonbackground = '';
         $buttontextcolor = '';


        

        if(isset($_REQUEST['calendarbackground']))
        {
            $calendarbackground = $_REQUEST['calendarbackground'];
        }

        if(isset($_REQUEST['highlightedbackground']))
        {
            $highlightedbackground = $_REQUEST['highlightedbackground'];
        }

        if(isset($_REQUEST['calendertextcolor']))
        {
            $calendertextcolor = $_REQUEST['calendertextcolor'];
        }

        if(isset($_REQUEST['buttonbackground']))
        {
            $buttonbackground = $_REQUEST['buttonbackground'];
        }

        if(isset($_REQUEST['buttontextcolor']))
        {
            $buttontextcolor = $_REQUEST['buttontextcolor'];
        }

        if(isset($_REQUEST['heighlightedtextcolor']))
        {
            $heighlightedtextcolor = $_REQUEST['heighlightedtextcolor'];
        }

         if(isset($_REQUEST['hdnSettingID']))
        {
            $settingID = $_REQUEST['hdnSettingID'];
        }

        $modifiedDateTime = date('Y-m-d h:i:s');


        $this->result = DB::update("UPDATE `bookingsitesetting` 
                                                        SET 
                                                        calendarbackground = :calendarbackground,
                                                        highlightedbackground = :highlightedbackground,
                                                        calendertextcolor = :calendertextcolor,
                                                        buttonbackground = :buttonbackground,
                                                        buttontextcolor = :buttontextcolor,
                                                        heighlightedtextcolor =:heighlightedtextcolor,
                                                        updated_at = :updated_at
                                                        WHERE 
                                                            id = :id", [
                                                                            
                                                                            "calendarbackground"=>$calendarbackground,
                                                                            "highlightedbackground"=>$highlightedbackground,
                                                                            "calendertextcolor"=>$calendertextcolor,
                                                                            "buttonbackground"=>$buttonbackground,
                                                                            "buttontextcolor"=>$buttontextcolor,
                                                                            "heighlightedtextcolor"=>$heighlightedtextcolor,
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
        return Reply::successWithData(__('messages.Bookings.bookingSiteUpdated'), $returnData);


    }


    
    
    


}                         
