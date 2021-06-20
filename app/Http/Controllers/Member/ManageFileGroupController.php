<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreProjectCategory;
use App\ProjectCategory;
use App\FileGroup;
use App\Project;
use Illuminate\Support\Facades\DB;
use App\userGroupFiles;

class ManageFileGroupController extends MemberBaseController
{
    //

    
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.files';
        $this->pageIcon = 'fa fa-file';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->categories = ProjectCategory::all();
        return view('admin.project-category.create', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCat()
    {
       // $this->groups = FileGroup::all();
       // print_r($this->groups);

       $this->projects = Project::all();
       //print_r($this->projects);

       $this->groups = DB::table('filegroups')
                        ->join('projects', 'filegroups.project_id' , '=', 'projects.id')
                        ->select('filegroups.*' , 'projects.project_name')
                        ->get();
        //print_r($this->groups);
        $this->data = array(
            'groups'=>$this->groups,
            'projects'=>$this->projects
        );
        return view('admin.user-file.create')->with('data', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectCategory $request)
    {
        $category = new ProjectCategory();
        $category->category_name = $request->category_name;
        $category->save();

        return Reply::success(__('messages.categoryAdded'));
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
        
        $fileGroup = new FileGroup();
        $fileGroup->name = $request->group_name;
        $fileGroup->project_id = $request->project_id;
        $fileGroup->save();
        $this->projects = Project::all();
        $count = FileGroup::count();
       $this->groups = DB::table('filegroups')
                        ->join('projects', 'filegroups.project_id' , '=', 'projects.id')
                        ->select('filegroups.*' , 'projects.project_name')
                        ->orderby('id','desc')->take(1)
                        ->get();
        //print_r($this->groups);
        $this->data = array(
            'groups'=>$this->groups,
            'projects'=>$this->projects,
            'key'=>$count
        );

        return Reply::successWithData(__('messages.groupAdded'),['data' => $this->data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Assign group employees.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignGroup(Request $request)
    {
        // return $request;
        $userID = $request->userID;
        $groupID = $request->groupID;
        // DB::table('users_group')->where('user_id', '=', $userID)->delete();
        $affected = DB::table('users_group')
              ->where('user_id', $userID)
              ->update(['deleted_at' => \Carbon\Carbon::now()]);

        $id = DB::table('users_group')
        ->insertGetId(array(
            'user_id' => $userID,
            'group_id' => $groupID,
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ));

        $returnData = array();
        // $categoryData = ProjectCategory::all();
        return Reply::successWithData(__('messages.groupAssigned'),['data' => $returnData]);
    }

    function deleteGroup($id)
    {
        $affected = DB::table('users_group')
              ->where('id', $id)
              ->update(['deleted_at' => \Carbon\Carbon::now()]);
        $returnData = array();
        // $categoryData = ProjectCategory::all();
        return Reply::successWithData(__('messages.groupDeactivated'),['data' => $returnData]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FileGroup::destroy($id);
        $categoryData = array();
        // $categoryData = ProjectCategory::all();
        return Reply::successWithData(__('messages.groupDeleted'),['data' => $categoryData]);
    }

    public function manageFiles(Request $request)
    {
        $this->fileTypes = DB::table('file-types')->get();
        $this->user = auth()->user();
        
        $userGroup = DB::table('users_group')
                        ->where('user_id','=',$this->user->id)
                        ->where('users_group.deleted_at')
                        ->select('group_id')
                        ->get();
        if(count($userGroup) > 0)
        {
            $userGroup_id = $userGroup[0]->group_id;
        }else {
            $userGroup_id = 0;
        }
        
        /*        
        $this->personalFiles = DB::table('users')
                        ->join('user_groupfiles', 'users.id','=', 'user_groupfiles.user_id')
                        ->join('file-types', 'file-types.id','=', 'user_groupfiles.file_type_id')
                        ->leftJoin('projects', 'projects.id',  '=', 'user_groupfiles.project_id')
                        ->select('users.id as userID', 'users.name as employeeName', 'user_groupfiles.filePath', 'file-types.name as fileType', 'projects.project_name as projectName' , 'user_groupfiles.created_at', 'user_groupfiles.updated_at')
                        ->where('user_groupfiles.file_type_id', '=' , '2')
                        ->where('user_groupfiles.user_id', '=' , $this->user->id)
                        ->get();

        $this->groups = DB::table('users')
                        ->join('user_groupfiles', 'users.id','=', 'user_groupfiles.user_id')
                        ->join('file-types', 'file-types.id','=', 'user_groupfiles.file_type_id')
                        ->Join('projects', 'projects.id',  '=', 'user_groupfiles.project_id')
                        ->select('users.id as userID', 'users.name as employeeName', 'user_groupfiles.filePath', 'file-types.name as fileType', 'projects.project_name as projectName' , 'user_groupfiles.created_at', 'user_groupfiles.updated_at')
                        ->where('user_groupfiles.file_type_id', '=' , '1')
                        ->where('user_groupfiles.user_group_id', '=' , $userGroup_id)
                         ->unionAll($this->personalFiles)
                        ->get();
        */
        $this->groups = DB::select('
        SELECT
        `users`.id as userID, 
        `users`.name as employeeName, 
        `user_groupfiles`.filePath, 
        `file-types`.name as fileType, 
        `projects`.project_name as projectName, 
        `user_groupfiles`.created_at, 
        `user_groupfiles`.updated_at
        FROM `users` join `user_groupfiles` on `users`.id=`user_groupfiles`.user_id
                    join `file-types` on `file-types`.id = `user_groupfiles`.file_type_id
                    left join `projects` on `projects`.id = `user_groupfiles`.project_id
                    where `user_groupfiles`.file_type_id =  2
                    and `user_groupfiles`.user_id = '.$this->user->id.'
         UNION ALL
         
         SELECT
        `users`.id as userID, 
        `users`.name as employeeName, 
        `user_groupfiles`.filePath, 
        `file-types`.name as fileType, 
        `projects`.project_name as projectName, 
        `user_groupfiles`.created_at, 
        `user_groupfiles`.updated_at
        FROM `users` join `user_groupfiles` on `users`.id=`user_groupfiles`.user_id
                    join `file-types` on `file-types`.id = `user_groupfiles`.file_type_id
                    join `projects` on `projects`.id = `user_groupfiles`.project_id
                    where `user_groupfiles`.file_type_id =  1
                    and `user_groupfiles`.`user_group_id` = '.$userGroup_id.'
                                    ');
        //$this->groups = [];
                       
        return view('member.user-file.manage-files', $this->data);
    }

    function addFiles(Request $request)
    {
        $this->userGroup_id = DB::table('users_group')
                        ->where('user_id','=',$this->user->id)
                        ->where('users_group.deleted_at')
                        ->select('group_id')
                        ->get();
        

        if(count($this->userGroup_id) >0 )
        //if($this->userGroup_id[0]->group_id)
        {
            $this->projects = DB::table('projects')->get();
        }
        else {
            $this->projects = [];
        }
        return view('member.user-file.add-file', $this->data);
    }

    function storeFiles(Request $request)
    {
        
        $this->user = auth()->user();
        $file_type = $request->get('chkfileType');
        $project_id = $request->get('project_id');
        if($file_type == 2)
        {
            $project_id = 0;
            $userGroup_id = 0;
        }
        else {
        $userGroup = DB::table('users_group')
                        ->where('user_id','=',$this->user->id)
                        ->where('users_group.deleted_at')
                        ->select('group_id')
                        ->get();
        $userGroup_id = $userGroup[0]->group_id;
        
        }
        
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
        }
        else{
            $returnData = [];
            return Reply::successWithData(__('messages.fileNotempty'), $returnData);    
        }
        
        $allocatedModel = new userGroupFiles();
        $allocatedModel->user_id   = $this->user->id;
        $allocatedModel->user_group_id   = $userGroup_id;
        $allocatedModel->file_type_id    = $file_type;
        $allocatedModel->project_id       = $project_id;
        $allocatedModel->filePath       = $relativeDestination.'/'.$filename;
        $allocatedModel->save();
      
        $returnData = [];
        return Reply::successWithData(__('messages.fileUploaded'), $returnData);
        
    }
}                         
