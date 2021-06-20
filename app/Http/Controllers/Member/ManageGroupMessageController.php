<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreProjectCategory;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\RoleUser;
use Auth;
use App\MessageGroup;
use App\ProjectCategory;
use App\FileGroup;
use App\Project;
use App\UserChat;


class ManageGroupMessageController extends MemberBaseController
{
    //

    
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.groupDiscussion';
        $this->pageIcon = 'fa fa-file';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $userID = request()->get('userID');
        $user = Auth::user();

        $this->user_id     = $user->id;
        $this->messageGroups = DB::select('
                                    SELECT id , name
                                    FROM
                                    messagegroup
                                    WHERE id in (select message_groupid from user_messagegroup where user_id = '.$this->user_id.')
                                ');
        return view('member.message-group.index', $this->data);

    }
    function saveMessages()
    {   
        
        $filePath = '';

        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $filename = $_FILES["image"]["name"];
            $filetype = $_FILES["image"]["type"];
            $filesize = $_FILES["image"]["size"];
            
            /*
            $destination =  $_SERVER['DOCUMENT_ROOT'].'/doffl/public/img/groupFiles/';
            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/doffl/public/img/groupFiles/';
            */

            
            $destination =  $_SERVER['DOCUMENT_ROOT'].'/public/img/groupFiles/';
            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/public/img/groupFiles/';
    
            move_uploaded_file($_FILES["image"]["tmp_name"], $destination . $filename);

            $filePath = $relativeDestination.'/'.$filename;
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
            ['user_id' => $user_id, 'message_groupid' => $groupID , 'messageText'=>$message , 'filePath'=>$filePath]

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
            (
             message_groupid = '.$message_groupid.'
             OR
             message_groupid = 0
             )
    ');
        // $this->chatDetails = $chatDetails;

        $chatMessage .= view('member.message-group.ajax-message-list', $this->data)->render();
        $chatMessage .= '<li id="scrollHere"></li>';

        return Reply::successWithData(__('messages.fetchChat'), ['chatData' => $chatMessage]);



    }


    /**
     * @param $chatDetails
     * @param $type
     * @return string
     */
    public function userChatData($chatDetails)
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
            message_groupid =   '.$message_groupid.'
    ');
        // $this->chatDetails = $chatDetails;

        $chatMessage .= view('member.user-chat.ajax-chat-list', $this->data)->render();
        $chatMessage .= '<li id="scrollHere"></li>';

        return Reply::successWithData(__('messages.fetchChat'), ['chatData' => $chatMessage]);
    }



    
}                         
