<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreProjectCategory;
use App\ProjectCategory;
use App\Project;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\User;
use App\clientCategory;
use App\Helper\Files;
use App\categoryArticles;
use App\Role;
use App\RoleUser;
use Auth;




class AdminPixelController extends AdminBaseController
{
    //

    
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.pixels';
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

        $this->pixels = DB::select('
        SELECT
            `id`,
            `pixelName`, 
            `pixelCode`
        FROM
            `pixle_config` WHERE created_by = '.$this->company_id.' AND deleted_at IS NULL ');

       return view('admin.pixel.index', $this->data);
    }

    public function addpixel()
    {
        return view('admin.pixel.addpixel', $this->data);
    }
    public function savepixel(Request $request)
    {

        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $totalRecords = count($_REQUEST['pixelName']);

        for($i=0 ; $i<$totalRecords; $i++)
        {
            $pixelName = '';
            $pixelCode = '';

            $pixelName = $_REQUEST['pixelName'][$i];
            $pixelCode = $_REQUEST['pixleCode'][$i];

            $pixelID = DB::table('pixle_config')->insertGetId(
                [
                    'pixelName'=>$pixelName,
                    'pixelCode'=> $pixelCode,
                    'created_by'=>$this->company_id
                ]
            );
        }

        $returnData = array();
        return Reply::successWithData(__('messages.pixel.pixelInserted'),['data' => $returnData]);
        exit();

    }

    public function editPixel($id)
    {
        
        $this->pixels = DB::select('
                                SELECT
                                    *
                                FROM
                                    `pixle_config` a                    
                                WHERE 
                                    id = '.$id.' ');

        return view('admin.pixel.editpixel', $this->data);
    }

    public function updatepixel(Request $request)
    {
            $pixelName = $request->pixelName;
            $pixelCode = $request->pixleCode;
            $pixelID = $request->pixelID;
            $modifiedDate = date('Y-m-d h:i:s');

            $this->result = DB::update("UPDATE 
                                        `pixle_config` 
                                    SET
                                        pixelName = :pixelName,
                                        pixelCode = :pixelCode,
                                        updated_at = :updated_at
                                    WHERE 
                                        id = :id", 
                                    [
                                        "pixelName" =>$pixelName,
                                        "pixelCode" =>$pixelCode, 
                                        "updated_at" => $modifiedDate,
                                        "id" => $pixelID]
                                ); 

        $returnData = array();
        return Reply::successWithData(__('messages.pixel.pixelUpdated'),['data' => $returnData]);
        exit();

    }

    public function deletePixel(Request $request)
    {
        $id = $_REQUEST['id'];

        $affected = DB::table('pixle_config')
        ->where('id', $id)
        ->update(['deleted_at' => \Carbon\Carbon::now()]);
            $returnData = array();
        return Reply::successWithData(__('messages.pixel.pixelDeleted'),['data' => $returnData]);

    }



}                         
