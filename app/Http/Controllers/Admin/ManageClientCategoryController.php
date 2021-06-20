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
use Auth;



class ManageClientCategoryController extends AdminBaseController
{
    //

    
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.kb.managecategory';
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

        $this->clientCategory = DB::select('
        SELECT
            `kb_client_categories`.id , 
            `kb_client_categories`.title, 
            `kb_client_categories`.description,
            `kb_client_categories`.shortDescription,
            `kb_client_categories`.created_at,
            `kb_client_categories`.visits,
            `companies`.company_name
        FROM
            `kb_client_categories` 
        JOIN
            `companies`
        ON
        `companies`.id = `kb_client_categories`.company_id
        WHERE `kb_client_categories`.company_id = '.$this->company_id.'  AND `kb_client_categories`.deleted_at IS NULL');
    
        $this->articles = DB::select('SELECT 
                                a.`category_id`,
                                COUNT(*) AS num
                            FROM
                                kb_category_articles a 
                             JOIN   
                                kb_client_categories b 
                            ON 
                                a.`category_id` = b.id
                             WHERE 
                                b.company_id = '.$this->company_id.'
                            GROUP BY
                                category_id');
        return view('admin.categories.managecategories', $this->data);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createcategory()
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $this->upload = can_upload();

        $this->companies = DB::select('
        SELECT
            `companies`.id , 
            `companies`.company_name
        FROM
            `companies` WHERE id = '.$this->company_id.' ' );

        return view('admin.categories.createcategory', $this->data);


    }

    
    public function saveCategory(Request $request)
    {

        $this->user = auth()->user();

        if($request->company_name == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.companyNotEmpty'));            
        }

        if($request->subject == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.categoryTitleNotEmpty'));            
        }

        if($request->shortDescription == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.categoryShortDescriptionNotEmpty'));            
        }



        if($request->description == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.categoryDescriptionNotEmpty'));            
        }


        $companyID = $request->company_name;
        $subject = $request->subject;
        $description = $request->description;
        $shortDescription = $request->shortDescription;
        $filename = '';
        
        if ($request->hasFile('image')) { 
            $destination = 'kbFiles';
            $fileObj = new Files();
            $filename = $fileObj->upload($request->image,$destination,150,150);

        }
        
         if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $filename = date('mdyhis').$_FILES["image"]["name"];
            $filetype = $_FILES["image"]["type"];
            $filesize = $_FILES["image"]["size"];
        }
        /*    
            if($_SERVER['HTTP_HOST'] == 'localhost')
            {
                      
                $destination =  $_SERVER['DOCUMENT_ROOT'].'/doffl/public/files/kbFiles/';
                
                $fileObj->upload($_FILES["image"],$destination,64,64);

                $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/doffl/public/files/kbFiles/';
            }else{
               $destination =  $_SERVER['DOCUMENT_ROOT'].'/public/files/kbFiles/';
                $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/public/files/kbFiles/';
            }

            // move_uploaded_file($_FILES["image"]["tmp_name"], $destination . $filename);
            }
*/
            /*
            if ($request->hasFile('file')) {    
            $upload = can_upload($request->file->getSize()/(1000*1024));
            if($upload) {
                $file = new LeadFiles();
                $file->user_id = $this->user->id;
                $file->lead_id = $request->lead_id;
                $file->hashname = Files::uploadLocalOrS3($request->file,'lead-files/'.$request->lead_id);
                $file->filename = $request->file->getClientOriginalName();
                $file->size = $request->file->getSize();
                $file->save();
            } else {
                return Reply::error(__('messages.storageLimitExceed', ['here' => '<a href='.route('admin.billing.packages'). '>Here</a>']));
            }
            }
        */

        if($filename == '')   
        {   
            $this->groups = [];
            return Reply::error(__('Please upload categtory image.'));            
        }

        $allocatedModel = new clientCategory();
        $allocatedModel->user_id   = $this->user->id;
        $allocatedModel->company_id   = $companyID;
        $allocatedModel->title   = $subject;
        $allocatedModel->description   = $description;
        $allocatedModel->shortDescription   = $shortDescription;
        $allocatedModel->filePath   = $filename;
        $allocatedModel->filesize   = $filesize;
        
        $allocatedModel->save();
        $returnData = [];
        return Reply::successWithData(__('messages.kb.categoryCreated'), $returnData);

     
    }

    public function editCategory($id)
    {
        

        $this->companies = DB::select('
        SELECT
            id,
            company_name
        FROM
            `companies`');
        
        $this->categoryRecord = DB::select('
                                SELECT
                                    *
                                FROM
                                    `kb_client_categories`
                                WHERE 
                                    id = '.$id.' ');

        return view('admin.categories.editcategory', $this->data);

    }

    public function updateCategory(Request $request)
    {

        $this->user = auth()->user();

        if($request->company_name == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.companyNotEmpty'));            
        }

        if($request->subject == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.categoryTitleNotEmpty'));            
        }

        if($request->shortDescription == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.categoryShortDescriptionNotEmpty'));            
        }


        if($request->description == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.categoryDescriptionNotEmpty'));            
        }



        $companyID = $request->company_name;
        $subject = $request->subject;
        $description = $request->description;
        $shortDescription = $request->shortDescription;
        $categoryID = $request->categoryID;
        $filename = $request->existingFilePath;

        $modifiedDateTime = date('Y-m-d h:i:s');

        if ($request->hasFile('image')) { 
            $destination = 'kbFiles';
            $fileObj = new Files();
            $filename = $fileObj->upload($request->image,$destination,150,150);

        }

        


        $this->result = DB::update("UPDATE `kb_client_categories` 
                                                        SET 
                                                        company_id = :companyID ,
                                                        title = :title,
                                                        `description` = :descriptions,
                                                        `shortDescription` = :shortDescription,
                                                        filePath = :filePath,
                                                        updated_at = :updated_at
                                                        WHERE 
                                                            id = :id", [
                                                                            "companyID" =>$companyID, 
                                                                            "title"=>$subject,
                                                                            'descriptions'=>$description,
                                                                            'shortDescription'=>$shortDescription,
                                                                            'filePath'=>$filename,
                                                                            'updated_at'=> $modifiedDateTime,
                                                                            "id" => $categoryID]); 

        $returnData = [];
        return Reply::successWithData(__('messages.kb.categoryUpated'), $returnData);

     
    }

    public function deleteCategory(Request $request)
    {
        $id= $request->id;

        $affected = DB::table('kb_client_categories')
              ->where('id', $id)
              ->update(['deleted_at' => \Carbon\Carbon::now()]);

              $returnData = [];
              return Reply::successWithData(__('messages.kb.categoryRemoved'), $returnData);
    }

    public function manageArticles(Request $request)
    {
        $id = $request->id;
        $this->categoryID = $request->id;
        $this->articles = DB::select('
                                SELECT
                                    a.title as categoryTitle,
                                    b.id,
                                    b.articleTitle,
                                    b.articleShortDescription,
                                    b.articleDescription,
                                    b.articleFilePath,
                                    b.visits,
                                    b.created_at
                                FROM
                                    `kb_client_categories` a
                                JOIN
                                    `kb_category_articles` b
                                ON
                                    a.id = b.category_id
                                WHERE 
                                    a.id = '.$id.' 
                                AND
                                    b.deleted_at IS NULL');

    return view('admin.categories.manageArticles', $this->data);

    }

    public function createArticle($categoryID)
    {
        $this->categories = DB::select('
        SELECT
            id,
            title
        FROM
            `kb_client_categories` WHERE id='.$categoryID.'');

        return view('admin.categories.createarticle', $this->data);

    }

    public function saveArticle(Request $request)
    {
       // return $request;

        if($request->articleSubject == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.articletitleNoEmpty'));            
        }

        if($request->articleShortDescription == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.articleShortDescNoEmpty'));            
        }



        if($request->articleDescription == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.articleDescNoEmpty'));            
        }



        $categoryID = $request->categoryID;
        $articleSubject = $request->articleSubject;
        $articleShortDescription = $request->articleShortDescription;
        $articleDescription = $request->articleDescription;
        $filename = '';

        $allocatedModel = new categoryArticles();
        $allocatedModel->category_id   = $categoryID;
        $allocatedModel->articleTitle   = $articleSubject;
        $allocatedModel->articleShortDescription   = $articleShortDescription;
        $allocatedModel->articleDescription	   = $articleDescription;

        $allocatedModel->save();
        $returnData = ['categoryID'=>$categoryID];
        return Reply::successWithData(__('messages.kb.articleCreated'), $returnData);

    }

    public function editArticle($id)
    {
        $this->articleRecord = DB::select('
                                SELECT
                                    *
                                FROM
                                    `kb_category_articles`
                                WHERE 
                                    id = '.$id.' ');

        return view('admin.categories.editArticle', $this->data);

    }

    public function updateArticle(Request $request)
    {

        $modifiedDateTime = date('Y-m-d h:i:s');
        if($request->articleSubject == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.articletitleNoEmpty'));            
        }

        if($request->articleShortDescription == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.articleShortDescNoEmpty'));            
        }

        if($request->articleDescription == '')   
        {   
            $this->groups = [];
            return Reply::error(__('messages.kb.articleDescNoEmpty'));            
        }

        $categoryID = $request->categoryID;
        $articleID = $request->articleID;
        $articleSubject = $request->articleSubject;
        $articleDescription = $request->articleDescription;
        $articleShortDescription   = $request->articleShortDescription;
        

        $this->result = DB::update("UPDATE `kb_category_articles` 
        SET 
            articleTitle = :articleTitle,
            `articleDescription` = :articleDescription,
            `articleShortDescription` =:articleShortDescription,
            updated_at = :updated_at
            WHERE 
                id = :id", [
                                "articleTitle"=>$articleSubject,
                                "articleShortDescription"=>$articleShortDescription,
                                'articleDescription'=>$articleDescription,
                                'updated_at'=> $modifiedDateTime,
                                "id" => $articleID]); 

            $returnData = ['categoryID'=>$categoryID];
            return Reply::successWithData(__('messages.kb.articleUpated'), $returnData);


    }

    public function deleteArticle(Request $request)
    {
        $id = $request->id;
        $categoryID = $request->categoryID;

        $affected = DB::table('kb_category_articles')
              ->where('id', $id)
              ->update(['deleted_at' => \Carbon\Carbon::now()]);

              $returnData = ['categoryID'=>$categoryID];
              return Reply::successWithData(__('messages.kb.articleRemoved'), $returnData);
    }

    

    public function saveGeneral(Request $request)
    {
        if(isset($_REQUEST['company_name']))
        {
            $companyID = $_REQUEST['company_name'];
        }

        if(isset($_REQUEST['siteTitle']))
        {
            $siteTitle = $_REQUEST['siteTitle'];
        }

        if(isset($_REQUEST['welcomeText']))
        {
            $welcomeText = $_REQUEST['welcomeText'];
        }

        if(isset($_REQUEST['gridCheck']))
        {
            $gridCheck = $_REQUEST['gridCheck'];
        }

        if($gridCheck == 'on')
        {
            $gridChk = 1;
        }
        else {
            $gridChk = 0;
        }


        $settingID = DB::delete('DELETE FROM kb_site_settings where company_id = "'.$companyID.'" ');

        $settingID = DB::table('kb_site_settings')->insertGetId(
            ['company_id'=> $companyID , 'siteTitle' => $siteTitle , 'welcomeText'=>$welcomeText , 'gridCheck' => $gridChk]
        );

       $returnData = array('settingID'=>$settingID);
       return Reply::successWithData(__('messages.kb.generalSetting'),['data' => $returnData]);
       exit();


    }

    public function saveDesign(Request $request)
    {

        $settingID = '';
        $theme1 = '';
        $theme2 = '';
        
        if(isset($_REQUEST['settingID']))
        {
            $settingID = $_REQUEST['settingID'];
        }

        if(isset($_REQUEST['theme1']))
        {
            $theme1 = $_REQUEST['theme1'];
        }

        if(isset($_REQUEST['theme2']))
        {
            $theme2 = $_REQUEST['theme2'];
        }

 
        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $filename = date('mdyhis').$_FILES["image"]["name"];
            $filetype = $_FILES["image"]["type"];
            $filesize = $_FILES["image"]["size"];
            
            if($_SERVER['HTTP_HOST'] == 'localhost')
            {
           
            $destination =  $_SERVER['DOCUMENT_ROOT'].'/doffl/public/files/kbFiles/clientLogos/';
            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/doffl/public/files/kbFiles/clientLogos/';
           }else{
            $destination =  $_SERVER['DOCUMENT_ROOT'].'/public/files/kbFiles/clientLogos/';
            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/public/files/kbFiles/clientLogos/';
            }
           
            

            move_uploaded_file($_FILES["image"]["tmp_name"], $destination . $filename);
        }


        // $this->result = DB::update("UPDATE `kb_site_settings` SET logoPath = :logoPath , theme1 = :theme1 , theme2 = :theme2 WHERE id = :id", ["logoPath" =>$basicUrl, "id" => $surveyID]); 

        $this->result = DB::update("UPDATE `kb_site_settings` SET logoPath = :logoPath , theme1 = :theme1 , theme2 = :theme2  WHERE id = :id", ["logoPath" =>$filename, "theme1" =>$theme1, "theme2" =>$theme2, "id" => $settingID]); 

       $returnData = array('settingID'=>$settingID);
       return Reply::successWithData(__('messages.kb.ThemeSetting'),['data' => $returnData]);
       exit();

    }

    public function saveTrack(Request $request)
    {


        $settingID = '';
        $googleTracking = '';
        
        
        if(isset($_REQUEST['settingID']))
        {
            $settingID = $_REQUEST['settingID'];
        }

        if(isset($_REQUEST['googleTracking']))
        {
            $googleTracking = $_REQUEST['googleTracking'];
        }


        $this->result = DB::update("UPDATE `kb_site_settings` SET googleTracking = :googleTracking  WHERE id = :id", ["googleTracking" =>$googleTracking,  "id" => $settingID]); 
       $returnData = array('settingID'=>$settingID);
       return Reply::successWithData(__('messages.kb.GoogleSetting'),['data' => $returnData]);
       exit();




    }
    

    public function siteSetting(Request $request)
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $this->kbSettings = DB::select('
        SELECT
            *
        FROM
            `kb_site_settings` WHERE company_id =  '.$this->company_id.'');


        $this->existingpixels = DB::select('
                                SELECT 
                                    a.pixel 
                                FROM 
                                    `kb_site_settings_pixel` a
                                  JOIN 
                                    `kb_site_settings` b 
                                   ON   
                                    a.settingID = b.id
                                  WHERE 
                                    b.company_id = '.$this->company_id.'' );


        $this->pixels = DB::select('
        SELECT
            *
        FROM
            `pixle_config` WHERE created_by =  '.$this->company_id.'');

        return view('admin.kbSetting.addKBSetting', $this->data);
    }

    public function addKBSetting(Request $request)
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $this->kbSettings = DB::select('
        SELECT
            *
        FROM
            `kb_site_settings` WHERE company_id =  '.$this->company_id.'');

        return view('admin.kbSetting.addKBSetting', $this->data);
    }
    function saveSetting(Request $request)
    {
        // return $request;        
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $siteTitle = '';
        $welcomeText = '';
        $headertheme = '';
        $headercolor = '';
        
        $pixels = '';


        if(isset($_REQUEST['siteTitle']))
        {
            $siteTitle = addslashes($_REQUEST['siteTitle']);
        }

        if(isset($_REQUEST['welcomeText']))
        {
            $welcomeText = addslashes($_REQUEST['welcomeText']);
        }

        if(isset($_REQUEST['headertheme']))
        {
            $headertheme = $_REQUEST['headertheme'];
        }

        if(isset($_REQUEST['headercolor']))
        {
            $headercolor = $_REQUEST['headercolor'];
        }
       

        if(isset($_REQUEST['pixels']))
        {
            $pixels = $_REQUEST['pixels'];
        }


        $deleteQuery = DB::delete('DELETE FROM kb_site_settings where company_id = "'.$this->company_id.'" ');
        
        $settingID = DB::table('kb_site_settings')->insertGetId(
            ['company_id'=> $this->company_id , 'siteTitle' => $siteTitle , 'welcomeText'=>$welcomeText , 'headertheme' => $headertheme, 'headercolor' => $headercolor]);

        if(!empty($pixels))
        {
            foreach($pixels as $key=>$value)
            {
                $pixelID = DB::table('kb_site_settings_pixel')->insertGetId(
                ['settingID'=> $settingID , 'pixel' => $value]);
            }
        }
        $returnData = array();
        return Reply::successWithData(__('messages.kb.generalSetting'),['data' => $returnData]);
        exit();

    }
    
    function updateSetting(Request $request)
    {
        // return $request;

        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $siteTitle = '';
        $welcomeText = '';
        $headertheme = '';
        $headercolor = '';
        $bodycolor = '';
        $pixels = '';
        $settingID = '';


        if(isset($_REQUEST['siteTitle']))
        {
            $siteTitle = addslashes($_REQUEST['siteTitle']);
        }

        if(isset($_REQUEST['welcomeText']))
        {
            $welcomeText = addslashes($_REQUEST['welcomeText']);
        }

        if(isset($_REQUEST['headertheme']))
        {
            $headertheme = $_REQUEST['headertheme'];
        }

        if(isset($_REQUEST['headercolor']))
        {
            $headercolor = $_REQUEST['headercolor'];
        }
        
        if(isset($_REQUEST['pixels']))
        {
            $pixels = $_REQUEST['pixels'];
        }

        if(isset($_REQUEST['hdnSettingID']))
        {
            $settingID = $_REQUEST['hdnSettingID'];
        }

        $modifiedDateTime = date('Y-m-d h:i:s');


        $this->result = DB::update("UPDATE `kb_site_settings` 
                                                        SET 
                                                        company_id = :company_id ,
                                                        siteTitle = :siteTitle,
                                                        `welcomeText` = :welcomeText,
                                                        headertheme = :headertheme,
                                                        headercolor =:headercolor,
                                                        
                                                        updated_at = :updated_at
                                                        WHERE 
                                                            id = :id", [
                                                                            "company_id" =>$this->company_id, 
                                                                            "siteTitle"=>$siteTitle,
                                                                            'welcomeText'=>$welcomeText,
                                                                            'headertheme'=>$headertheme,
                                                                            'headercolor' => $headercolor,
                                                                            'updated_at'=> $modifiedDateTime,
                                                                            "id" => $settingID]); 


        if(!empty($pixels))
        {
            $deleteQuery = DB::delete('DELETE FROM kb_site_settings_pixel where settingID = "'.$settingID.'" ');
            foreach($pixels as $key=>$value)
            {
                $pixelID = DB::table('kb_site_settings_pixel')->insertGetId(
                ['settingID'=> $settingID , 'pixel' => $value]);
            }
        }


        $returnData = [];
        return Reply::successWithData(__('messages.kb.generalSettingUpdated'), $returnData);


    }

}                         
