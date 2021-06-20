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
// use Illuminate\Support\Facades\DB;


class AdminFileController extends AdminBaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.files';
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
        $userID = request()->get('userID');
        $id     = $userID;
        $name   = '';
        $this->groups = FileGroup::all();
    
        // $this->users = User::all();
        
        $this->usergroups =  DB::table('users')
                        ->leftJoin('users_group', function($join) {
                            $join->on('users.id', '=' , 'users_group.user_id')
                                ->where('users_group.deleted_at');
                        })
                        ->leftJoin('filegroups', 'filegroups.id' , '=' , 'users_group.group_id')
                        ->select('users.id', 'users.name as employeeName', 'filegroups.name as groupName', 'users_group.id as userGroupID')
                         ->get();
        
        // $this->project = Project::all();
            // print_r($this->groups);
        
        return view('admin.user-file.index', $this->data);

    }  

}
