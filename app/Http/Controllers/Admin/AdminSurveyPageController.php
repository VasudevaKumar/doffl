<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helper\Reply;
use App\Http\Requests\Project\StoreProjectCategory;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\RoleUser;
use Auth;



class AdminSurveyPageController extends AdminBaseController
{
    //

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.surveys';
        $this->pageIcon = 'fa fa-file';
    }

    public function manageSurveys()
    {   
        $user = Auth::user();
        $this->user_id     = $user->id;
        return view('admin.surveys.index', $this->data);
    } 

    public function surveyRecord()
    {   
        $user = Auth::user();
        $this->user_id     = $user->id;
        return view('admin.surveys.record', $this->data);
    } 
    public function surveyList()
    {   
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $this->surveys = DB::select("  SELECT 	
                                            a.id,
                                            a.user_id,
                                            a.surveyLink,
                                            b.name,
                                            a.created_at,
                                            a.views

                                        FROM
                                            surveys a 
                                        JOIN
                                            users b
                                        ON
                                            a.user_id = b.id
                                        WHERE
                                            a.company_id = ".$this->company_id."
                                        AND
                                            a.surveyLink IS NOT NULL 
                                        AND
                                            a.deleted_at IS NULL
                                        ");
        return view('admin.surveys.list', $this->data);
    }

    public function saveQuestion(Request $request)
    {
       $mainFilesArray = array();
       $finalArray = array();
       $totalQuestions = count($_REQUEST['questions']);
       $finalFilesArray = array();
       $countOfMainFile = '';
        $totalQuestionCount = '';

        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

       // echo 'Total'.$totalQuestions;
       /*
       echo '<pre>';
       print_r($_REQUEST);
       echo '</pre>';

       echo '<pre>';
       print_r($_FILES);
       echo '</pre>';
        */
        $totalFiles = count($_FILES);
       // echo $totalFiles;
    

       for($i=0; $i<$totalFiles; $i++)
       {
           $keyVal = $i+1;
            $fileKey = 'surveyFiles_'.$keyVal;
            $mainFilesArray[$i] = $_FILES[$fileKey];

       }
       
       if(!empty($mainFilesArray))
       {
           $countOfMainFile = count($mainFilesArray);
         //   echo 'count'.$countOfMainFile;
           
           for($out=0; $out<$countOfMainFile; $out++)
           {
               $numberofFiles = count($mainFilesArray[$out]['name']);
              
               for($inner=0; $inner<$numberofFiles; $inner++)
               {
                    $finalFilesArray[$out]['name'] = $mainFilesArray[$out]['name'];
                    $finalFilesArray[$out]['type'] = $mainFilesArray[$out]['type'];
                    $finalFilesArray[$out]['tmp_name'] = $mainFilesArray[$out]['tmp_name'];
                    $finalFilesArray[$out]['error'] = $mainFilesArray[$out]['error'];
                    $finalFilesArray[$out]['size'] = $mainFilesArray[$out]['size'];
               }
              
           }
          

       }
      

      
       for($j=0; $j<$totalQuestions; $j++)
       {
            $finalArray[$j]['questions'] = $_REQUEST['questions'][$j];
            $finalArray[$j]['questionType'] = $_REQUEST['questionType'][$j];
            $finalArray[$j]['options'] = $_REQUEST['options'][$j];
         
            if($_REQUEST['questionType'][$j] == 'Picture Choice')
            {
                $finalArray[$j]['files']  = $finalFilesArray[$j];
            }
       }
     
       /*
       echo '<pre>';
       print_r($mainFilesArray);
       echo '</pre>';
      */
       
      /*
       echo 'xxxxxxxxxxxxxx';
       echo '<pre>';
       print_r($finalFilesArray);
       echo '</pre>';
      */
       /*
       echo '<pre>';
       print_r($finalArray);
       echo '</pre>';
       //exit();
       */
    
       if(!empty($finalArray))
       {
           $totalQuestionCount = count($finalArray);

           $surveyID = DB::table('surveys')->insertGetId(
                ['user_id'=> $this->user_id , 'company_id'=>$this->company_id,'surveyLink' => NULL]
            );

           for($f=0; $f < $totalQuestionCount; $f++)
           {
               $questionName = $finalArray[$f]['questions'];
               $questionType = $finalArray[$f]['questionType'];
               $options = $finalArray[$f]['options'];
               
              
              
               $lastInsertID = DB::table('survey_questions')->insertGetId(
                    ['survey_id' => $surveyID , 'questionName' => $questionName, 'questionType' => $questionType]
                );
              

                
                if($questionType == 'Picture Choice')
                {
                    $numberOfFiles = count($finalArray[$f]['files']['name']);
                    for($in=0; $in<$numberOfFiles; $in++)
                    {
                        if($finalArray[$f]['files']["error"][$in] == 0){
                            $filename = time().$finalArray[$f]['files']["name"][$in];
                            $filetype = $finalArray[$f]['files']["type"][$in]; 
                            $filesize = $finalArray[$f]['files']["size"][$in]; 
                            
                             
                            $destination =  $_SERVER['DOCUMENT_ROOT'].'/doffl/public/img/surveyFiles/';
                            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/doffl/public/img/surveyFiles/';
                           /*
                            $destination =  $_SERVER['DOCUMENT_ROOT'].'/public/img/surveyFiles/';
                            $relativeDestination = 'http://'.$_SERVER['HTTP_HOST'].'/public/img/surveyFiles/';
                            */
                            
                            move_uploaded_file($finalArray[$f]['files']["tmp_name"][$in], $destination . $filename);

                            $result = DB::table('survey_questions_files')->insertGetId(
                                ['question_id' => $lastInsertID, 'filePath' => $filename]
                            );


                        }
                    }
                }

                if($questionType == 'Multiple Choice' || $questionType == 'Dropdown')
                {
                    $affected = DB::table('survey_questions')
                    ->where('id', $lastInsertID)
                    ->update(['options' => $options]);
                }
                
           }
       }
       
       $returnData = array('surveyID'=>$surveyID);
       return Reply::successWithData(__('messages.questionInserted'),['data' => $returnData]);
       exit();
    } // save questions.

    public function saveDesigns(Request $request)
    {
        
             
        $surveyID = '';
        $fontstyle = '';
        $QColor = '';
        $AColor = '';
        $BColor = '';
        $BackColor = '';

        if(isset($_REQUEST['surveyID']))
        {
            $surveyID = $_REQUEST['surveyID'];
        }

        if(isset($_REQUEST['fontstyle']))
        {
            $fontstyle = $_REQUEST['fontstyle'];
        }

        if(isset($_REQUEST['QColor']))
        {
            $QColor = $_REQUEST['QColor'];
        }

        if(isset($_REQUEST['AColor']))
        {
            $AColor = $_REQUEST['AColor'];
        }

        if(isset($_REQUEST['BColor']))
        {
            $BColor = $_REQUEST['BColor'];
        }

        if(isset($_REQUEST['BackColor']))
        {
            $BackColor = $_REQUEST['BackColor'];
        }

        
        $results = DB::table('survey_styles')->insertGetId(
            ['survey_id' => $surveyID , 'fontstyle' => $fontstyle, 'QColor' => $QColor, 'AColor'=>$AColor , 'BColor'=>$BColor , 'BackColor'=>$BackColor]
        );

        $returnData = array('surveyID'=>$surveyID);
       return Reply::successWithData(__('messages.stylesConfigured'),['data' => $returnData]);
       exit();

    }
    public function saveURL(Request $request)
    {
        $surveyID = '';
        $surveyLink = '';

        if(isset($_REQUEST['surveyID']))
        {
            $surveyID = $_REQUEST['surveyID'];
        }

        if(isset($_REQUEST['basicUrl']))
        {
            $basicUrl = 'http://'.$_SERVER['HTTP_HOST'].'/survay-pages/index.php?q='.$_REQUEST['basicUrl'];
            
        }
        $returnData = array('surveyID'=>$surveyID);
        $this->surveyUrl = DB::select("SELECT id FROM `surveys` WHERE surveyLink = :surveyLink", ["surveyLink" =>$basicUrl]);
        if(count($this->surveyUrl) == 0)
        {
            $this->result = DB::update("UPDATE `surveys` SET surveyLink = :surveyLink WHERE id = :id", ["surveyLink" =>$basicUrl, "id" => $surveyID]); 
            $returnData = array('surveyID'=>$surveyID, 'surveyLink'=>$basicUrl);
            return Reply::successWithData(__('messages.urlConfigured'),['data' => $returnData]);
            exit();
        }
        else{
            $returnData = array('surveyID'=>$surveyID);
            return Reply::error(__('messages.surveyLinkExisted'));
            exit();
        }
    }

    function deleteSurvey($id)
    {
        $affected = DB::table('surveys')
              ->where('id', $id)
              ->update(['deleted_at' => \Carbon\Carbon::now()]);
        $returnData = array();
        // $categoryData = ProjectCategory::all();
        return Reply::successWithData(__('messages.surveyDeleted'),['data' => $returnData]);
    }

    function showResponces($id)
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
       
       
        $this->responces = DB::select("  SELECT 	
                                        a.id,
                                        a.user_id,
                                        a.surveyLink,
                                        c.answer,
                                        c.IP,
                                        c.created_at AS 'Answer_at',
                                        c.answerGroup,
                                        b.questionName,
                                        b.questionType,
                                        b.survey_id
                                    FROM
                                        surveys a 
                                    JOIN
                                        survey_questions b
                                    ON
                                        a.id = b.survey_id
                                    JOIN
                                        survey_answers c
                                    ON
                                        b.id = c.question_id
                                    WHERE
                                        a.id = ".$id."
                                    ORDER BY
                                        c.answerGroup  
                                        ");
        
        return view('admin.surveys.ajax-listings', $this->data);

    }



    


}