<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreProjectCategory;
use App\ProjectCategory;
use App\FileGroup;
use App\Project;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\RoleUser;
use Auth;
use App\MessageGroup;


class AdminMessageGroupController extends AdminBaseController
{
    //

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.groupDiscussion';
        $this->pageIcon = 'fa fa-file';

        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if($user->isAdmin($user->id)){
                return $next($request);
            }
            else{
                return redirect()->route('fileGroupCategory.manage-files');
            }

        });

    }

    public function index()
    {   
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->messageGroups = MessageGroup::all();
        return view('admin.message-group.index', $this->data);
    }  

    public function showGroupsindex()
    {   
        $userID = request()->get('userID');
        $id     = $userID;
        $this->messageGroups = MessageGroup::all();
        $this->users = User::all();
        $this->userMessageGroups = DB::select('
                                                SELECT message_groupid , count(user_id) as userID FROM `user_messagegroup` GROUP BY message_groupid                                               
                                            ');
        return view('admin.message-group.showGroups', $this->data);

    }  


    public function showMembers($id)
    {
    
        $this->memberGroupID = $id;
        $this->existingEmployees = DB::select('
                                                SELECT
                                                    a.id as user_id,
                                                    a.name as employeeName,
                                                    c.name as roleName,
                                                    u.id as groupID
                                                FROM
                                                    users a 
                                                JOIN
                                                    role_user b
                                                ON  
                                                    a.id= b.user_id
                                                JOIN
                                                    roles c 
                                                ON
                                                    c.id = b.role_id
                                                JOIN
                                                    user_messagegroup u
                                                ON
                                                    a.id = u.user_id
                                                WHERE
                                                    u.message_groupid = "'.$id.'"
                                                AND
                                                    u.deleted_at IS NULL
                                            ');

        
        $this->employees = DB::select('
                                    SELECT
                                        DISTINCT
                                        a.id,
                                        a.name ,
                                        a.email
                                    FROM
                                        users a 
                                    WHERE 
                                        a.id NOT IN (SELECT user_id FROM user_messagegroup where id = '.$id.') 
                                    AND
                                        a.company_id IS NOT NULL');
                                    

        
        return view('admin.message-group.members', $this->data);
      

    }

    public function sendMessage($id)
    {
    
        $this->memberGroupID = $id;
        $this->existingEmployees = DB::select('
                                                SELECT
                                                    a.id as user_id,
                                                    a.name as employeeName,
                                                    c.name as roleName,
                                                    u.id as groupID
                                                FROM
                                                    users a 
                                                JOIN
                                                    role_user b
                                                ON  
                                                    a.id= b.user_id
                                                JOIN
                                                    roles c 
                                                ON
                                                    c.id = b.role_id
                                                JOIN
                                                    user_messagegroup u
                                                ON
                                                    a.id = u.user_id
                                                WHERE
                                                    u.message_groupid = "'.$id.'"
                                                AND
                                                    u.deleted_at IS NULL
                                            ');

                
        return view('admin.message-group.sendMessage', $this->data);
      

    }

    function showMessageToGroup($id)
    {

        // $message_groupid = $_REQUEST['groupID'];
        $this->groups = DB::select('
        SELECT 
            a.user_id,
            a.message_groupid,
            a.messageText,
            a.filePath,
            a.created_at,
            b.name as employeeName
        FROM 
            user_messagegroup_details a 
        JOIN
            users b
        ON 
            a.user_id = b.id 
        WHERE 
            message_groupid = '.$id.'
    ');

    return view('admin.message-group.showMessage', $this->data);

    }





}
