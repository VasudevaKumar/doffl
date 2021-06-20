<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreProjectCategory;
use App\ProjectCategory;
use App\FileGroup;
use App\Project;
use Auth;
use Illuminate\Support\Facades\DB;
use App\MessageGroup;
use App\Helper\Files;


class ManageMessageGroups extends AdminBaseController
{
    //

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.files';
        $this->pageIcon = 'fa fa-file';

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCat()
    {

       $this->groups = DB::table('messagegroup')
                           ->select('messagegroup.*')
                        ->get();
        //print_r($this->groups);
        $this->data = array(
            'groups'=>$this->groups
        );
        return view('admin.message-group.create')->with('data', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function storeGroup(StoreProjectCategory $request)
    public function storeGroup(Request $request)
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        if($request->group_name == '')   
        {   
            $this->groups = [];
            return Reply::successWithData(__('messages.groupNotEmpty'),['data' => $this->data]);            
        }
        elseif(!preg_match('/^[a-z0-9 .\-]+$/i', $request->group_name))
        {
            $this->groups = [];
            return Reply::successWithData(__('messages.groupNospecial'),['data' => $this->data]);            
        }
        $filename = '';
        if ($request->hasFile('image')) { 
            $destination = 'messagegroup';
            $fileObj = new Files();
            $filename = $fileObj->upload($request->image,$destination,30,30);

        }
        
         if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $filetype = $_FILES["image"]["type"];
            $filesize = $_FILES["image"]["size"];
        }

        if($filename == '')   
        {   
            $this->groups = [];
            return Reply::error(__('Please upload image.'));            
        }

        $fileGroup = new MessageGroup();
        $fileGroup->name = $request->group_name;
        $fileGroup->image = $filename;
        $fileGroup->filesize = $filesize;
        $fileGroup->company_id = $this->company_id;
        $fileGroup->save();
        $count = MessageGroup::count();
       $this->groups = DB::table('MessageGroup')
                        ->select('MessageGroup.*')
                        ->orderby('id','desc')->take(1)
                        ->get();
        //print_r($this->groups);
        $this->data = array(
            'groups'=>$this->groups,
            'key'=>$count
        );

        return Reply::successWithData(__('messages.groupAdded'),['data' => $this->data]);
    }
    public function destroy($id)
    {
        MessageGroup::destroy($id);
        $categoryData = array();
        // $categoryData = ProjectCategory::all();
        return Reply::successWithData(__('messages.groupDeleted'),['data' => $categoryData]);
    }

    function assignMessageGroup(Request $request)
    {

        $groupID = $request->groupID;
        $users = $request->user_id;

       if(empty($users))
       {
            $returnData = array();
            return Reply::successWithData(__('messages.employeesRequiredForGroup'),['data' => $this->data]);
       }
      
        foreach($users as $key=>$value)
        {
           
            $affected = DB::table('user_messagegroup')
                ->where('user_id', $value)
                ->where('message_groupid', $groupID)
                ->update(['deleted_at' => \Carbon\Carbon::now()]);
    
            $id = DB::table('user_messagegroup')
            ->insertGetId(array(
                'user_id' => $value,
                'message_groupid' => $groupID,
                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
            ));

        }
       
         $returnData = array();
         // $categoryData = ProjectCategory::all();
         return Reply::successWithData(__('messages.groupAssigned'),['data' => $returnData]);


    }

    function removeMessageGroup(Request $request)
    {
       
        $affected = DB::table('user_messagegroup')
                ->where('user_id', $request->userId)
                ->where('id', $request->groupId)
                ->update(['deleted_at' => \Carbon\Carbon::now()]);
                $returnData = array();
        return Reply::successWithData(__('messages.removedEmployeeFromGroup'),['data' => $returnData]);

    }

    function sendMessageToGroup(Request $request)
    {
        $user = Auth::user();
        $user_id    = $user->id;
        
        $filePath = '';


        if ($request->hasFile('image')) { 
            $destination = 'groupFiles';
            $fileObj = new Files();
            $filePath = $fileObj->upload($request->image,$destination,150,150);

        }


        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $filesize = $_FILES["image"]["size"];
        }
            /*
            $destination =  $_SERVER['DOCUMENT_ROOT'].'/doffl/public/img/groupFiles/';
            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/doffl/public/img/groupFiles/';
           
           
            $destination =  $_SERVER['DOCUMENT_ROOT'].'/public/img/groupFiles/';
            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/public/img/groupFiles/';
           
            move_uploaded_file($_FILES["image"]["tmp_name"], $destination . $filename);
 
        $filePath = $relativeDestination.'/'.$filename;
        }
         */
        
        if(isset($_REQUEST['message']))
        {
            $message = $_REQUEST['message'];
        }

        if(isset($_REQUEST['user_id']))
        {
            $user_id = $_REQUEST['user_id'];
        }

        if(isset($_REQUEST['groupID']))
        {
            $groupID = $_REQUEST['groupID'];
        }
       DB::table('user_messagegroup_details')->insert([
            ['user_id' => $user_id, 'message_groupid' => $groupID , 'messageText'=>$message , 'filePath'=>$filePath, 'filesize'=>$filesize]

        ]);

        return Reply::successWithData(__('messages.fetchChat'), ['messageText' => $message]);

        
    }

    function getMessages()
    {
        
        $message_groupid = $_REQUEST['groupID'];
       /*
        $this->messageDetails = DB::select('
                                                SELECT messageText FROM
                                                user_messagegroup_details
                                                WHERE message_groupid =  '.$message_groupid.'
                                            ');
        return Reply::successWithData(__('messages.fetchChat'), ['messageText' => $this->messageDetails]);
        */
        if($message_groupid >0 )
        {
            $chatMessage = '';
            $this->messageDetails = DB::select('
            SELECT 
                a.user_id,
                a.message_groupid,
                a.messageText,
                a.filePath,
                a.created_at,
                b.name
            FROM 
                user_messagegroup_details a 
            JOIN
                users b
            ON 
                a.user_id = b.id 
            WHERE 
                message_groupid = '.$message_groupid.'
        ');
            // $this->chatDetails = $chatDetails;

            $chatMessage .= view('member.message-group.ajax-message-list', $this->data)->render();
            $chatMessage .= '<li id="scrollHere"></li>';

            return Reply::successWithData(__('messages.fetchChat'), ['chatData' => $chatMessage]);
        }
        else {
            $chatMessage = '';
            $this->messageDetails = DB::select('
            SELECT 
                a.user_id,
                a.message_groupid,
                a.messageText,
                a.filePath,
                a.created_at,
                b.name
            FROM 
                user_messagegroup_details a 
            JOIN
                users b
            ON 
                a.user_id = b.id 
        ');
            // $this->chatDetails = $chatDetails;

            $chatMessage .= view('member.message-group.ajax-message-list', $this->data)->render();
            $chatMessage .= '<li id="scrollHere"></li>';

            return Reply::successWithData(__('messages.fetchChat'), ['chatData' => $chatMessage]);
        }


    }

    function saveMessages(Request $request)
    {   
        
        $filePath = '';
        $filesize = '';

        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;


        /*
        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $filename = $_FILES["image"]["name"];
            $filetype = $_FILES["image"]["type"];
            $filesize = $_FILES["image"]["size"];
            
            /*
            $destination =  $_SERVER['DOCUMENT_ROOT'].'/doffl/public/img/groupFiles/';
            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/doffl/public/img/groupFiles/';
            

            
            $destination =  $_SERVER['DOCUMENT_ROOT'].'/public/img/groupFiles/';
            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/public/img/groupFiles/';
    
            move_uploaded_file($_FILES["image"]["tmp_name"], $destination . $filename);

            $filePath = $relativeDestination.'/'.$filename;
        }*/

        if ($request->hasFile('image')) { 
            $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif')
            {
                $destination = 'groupFiles';
                $fileObj = new Files();
                $filePath = $fileObj->upload($request->image,$destination);
            }
            else{
                $destination = public_path('user-uploads/groupFiles/');
                 $filePath = date('ymdhis').$_FILES["image"]["name"];
                move_uploaded_file($_FILES["image"]["tmp_name"], $destination . $filePath);
            }

        }


        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $filesize = $_FILES["image"]["size"];
        }

        /*
        else{
            $returnData = [];
            return Reply::successWithData(__('messages.fileNotempty'), $returnData);    
        }
        */
        
        if(isset($_REQUEST['message']))
        {
            $message = $_REQUEST['message'];
        }

        if(isset($_REQUEST['user_id']))
        {
            $user_id = $_REQUEST['user_id'];
        }

        if(isset($_REQUEST['groupID']))
        {
            $groupID = $_REQUEST['groupID'];
        }
        
       DB::table('user_messagegroup_details')->insert([
            ['user_id' => $user_id, 'company_id' =>  $this->company_id, 'message_groupid' => $groupID , 'messageText'=>$message , 'filePath'=>$filePath , 'filesize'=>$filesize]

        ]);

        return Reply::successWithData(__('messages.fetchChat'), ['messageText' => $message]);


    }

    public function getUserSearch()
    {
        $term = request()->get('term');
        $this->messageGroups = $this->userListLatest($term);

        $users = '';

        $users = view('admin.message-group.ajax-user-list', $this->data)->render();

        return Reply::dataOnly(['userList' => $users]);
    }

    public function userListLatest($term = null)
    {
        // $result = User::userListLatest($this->user->id, $term);

         $result = DB::table('messagegroup')
                           ->select('messagegroup.*')
                           ->where('name', 'like', '%' . $term . '%')
                        ->get();
        return $result;
    }



    

}
