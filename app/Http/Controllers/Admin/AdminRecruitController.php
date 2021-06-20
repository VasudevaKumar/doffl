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




class AdminRecruitController extends AdminBaseController
{
    //

    
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.recruit.recruit';
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

        $this->companies = DB::select('
        SELECT
            `companies`.id , 
            `companies`.company_name
        FROM
            `companies` WHERE id =  '.$this->company_id.' ');
        
        return view('admin.recruit.index', $this->data);
    }
    public function saveJob(Request $request)
    {

        $user = Auth::user();
        $this->user_id     = $user->id;
        
        
        
        $job_title = '';
        $jobType = '';
        $minSalary = '';
        $maxSalary = '';
        $industry = '';
        $workFromHome = '';
        $resumeRequired = '';
        $additionalDocs = '';
        $additionalLinks = '';
        $job_description = '';
        $job_Responsibilities = '';
        $job_Benefits = '';
        $combinedQuestions = '';
        $combinedQuestionArray = array();
        $company_name = '';
        $terms = '';


        if(isset($_REQUEST['company_name']))
        {
            $company_id = $_REQUEST['company_name'];
        }
        if(isset($_REQUEST['job_title']))
        {
            $job_title = $_REQUEST['job_title'];
        }

        if(isset($_REQUEST['jobType']))
        {
            $jobType = $_REQUEST['jobType'];
        }

        if(isset($_REQUEST['minSalary']))
        {
            $minSalary = $_REQUEST['minSalary'];
        }

        if(isset($_REQUEST['maxSalary']))
        {
            $maxSalary = $_REQUEST['maxSalary'];
        }

        if(isset($_REQUEST['industry']))
        {
            $industry = $_REQUEST['industry'];
        }

        if(isset($_REQUEST['workFromHome']))
        {
            $workFromHome = $_REQUEST['workFromHome'];
        }

        if(isset($_REQUEST['resumeRequired']))
        {
            $resumeRequired = $_REQUEST['resumeRequired'];
        }

        if(isset($_REQUEST['additionalDocs']))
        {
            $additionalDocs = $_REQUEST['additionalDocs'];
        }

        if(isset($_REQUEST['additionalLinks']))
        {
            $additionalLinks = $_REQUEST['additionalLinks'];
        }

        if(isset($_REQUEST['job_description']))
        {
            $job_description = $_REQUEST['job_description'];
        }

        if(isset($_REQUEST['job_Responsibilities']))
        {
            $job_Responsibilities = $_REQUEST['job_Responsibilities'];
        }

        if(isset($_REQUEST['job_Benefits']))
        {
            $job_Benefits = $_REQUEST['job_Benefits'];
        }

        if(isset($_REQUEST['terms']))
        {
            $terms = $_REQUEST['terms'];
        }

        if(isset($_REQUEST['combinedQuestions']))
        {
            $combinedQuestions = $_REQUEST['combinedQuestions'];
            $combinedQuestionArray = explode('###', $combinedQuestions);
        }

      //  return $combinedQuestionArray;



        

        $recruid = DB::table('recruit_jobpostings')->insertGetId(
            [
                'company_id'=>$company_id,
                'job_title'=> $job_title , 
                'jobType' => $jobType,
                'minSalary'=>$minSalary,
                'maxSalary' => $maxSalary,
                'industry'=>$industry,
                'workFromHome'=>$workFromHome,
                'resumeRequired'=>$resumeRequired,
                'additionalDocs'=>$additionalDocs,
                'additionalLinks'=>$additionalLinks,
                'job_description'=>$job_description,
                'job_Responsibilities'=>$job_Responsibilities,
                'job_Benefits'=>$job_Benefits,
                'terms' => $terms,
                'created_by'=>$this->user_id
            ]
        );

        if(!empty($combinedQuestionArray))
        {
        foreach($combinedQuestionArray as $key=>$value)
        {    if($value !='')
                {
                    $result = DB::table('recruit_jobpostings_questions')->insertGetId(
                        [
                            'jobID'=> $recruid , 
                            'questionName' => $value,
                            'created_by'=>$this->user_id
                        ]
                    );
                }
            }
        }
        
        $returnData = array();
        return Reply::successWithData(__('messages.Recruit.jobInserted'),['data' => $returnData]);
        exit();

    }


    public function managejob()
    {

        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $this->jobs = DB::select("  SELECT 	
                        a.id,
                        a.jobType,
                        a.job_title,
                        a.minSalary,
                        a.maxSalary,
                        a.industry,
                        CASE WHEN (a.workFromHome = '1') THEN 'Yes' ELSE 'No' END workFromHome,
                        CASE WHEN (a.resumeRequired = '1') THEN 'Yes' ELSE 'No' END resumeRequired,
                        CASE WHEN (a.additionalDocs = '1') THEN 'Yes' ELSE 'No' END additionalDocs,
                        CASE WHEN (a.additionalLinks = '1') THEN 'Yes' ELSE 'No' END additionalLinks,
                        a.created_date,
                        a.views
                    FROM
                        recruit_jobpostings a 
                    WHERE
                        company_id = ".$this->company_id."
                    AND
                        deleted_date IS NULL
                    ");
        return view('admin.recruit.managejob', $this->data);
    }

    public function editJob($id)
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

        $this->jobrecord = DB::select('
                                SELECT
                                    *
                                FROM
                                    `recruit_jobpostings` a                    
                                WHERE 
                                    id = '.$id.' ');
        $this->questions = DB::select('
                                SELECT
                                    *
                                FROM
                                    `recruit_jobpostings_questions` a                    
                                WHERE 
                                    jobID = '.$id.' ');

        return view('admin.recruit.editjob', $this->data);

    }


    public function updateJob(Request $request)
    {

        $user = Auth::user();
        $this->user_id     = $user->id;
        
        //return $request;

        
        $job_title = '';
        $jobType = '';
        $minSalary = '';
        $maxSalary = '';
        $industry = '';
        $workFromHome = '';
        $resumeRequired = '';
        $additionalDocs = '';
        $additionalLinks = '';
        $job_description = '';
        $job_Responsibilities = '';
        $job_Benefits = '';
        $hdnJobId = '';
        $modifiedDate = date('Y-m-d h:i:s');
        $combinedQuestions = '';
        $combinedQuestionArray = array();
        $company_name = '';
        $terms = '';

        if(isset($_REQUEST['company_name']))
        {
            $company_id = $_REQUEST['company_name'];
        }
        if(isset($_REQUEST['job_title']))
        {
            $job_title = $_REQUEST['job_title'];
        }

        if(isset($_REQUEST['jobType']))
        {
            $jobType = $_REQUEST['jobType'];
        }

        if(isset($_REQUEST['minSalary']))
        {
            $minSalary = $_REQUEST['minSalary'];
        }

        if(isset($_REQUEST['maxSalary']))
        {
            $maxSalary = $_REQUEST['maxSalary'];
        }

        if(isset($_REQUEST['industry']))
        {
            $industry = $_REQUEST['industry'];
        }

        if(isset($_REQUEST['workFromHome']))
        {
            $workFromHome = $_REQUEST['workFromHome'];
        }

        if(isset($_REQUEST['resumeRequired']))
        {
            $resumeRequired = $_REQUEST['resumeRequired'];
        }

        if(isset($_REQUEST['additionalDocs']))
        {
            $additionalDocs = $_REQUEST['additionalDocs'];
        }

        if(isset($_REQUEST['additionalLinks']))
        {
            $additionalLinks = $_REQUEST['additionalLinks'];
        }

        if(isset($_REQUEST['job_description']))
        {
            $job_description = $_REQUEST['job_description'];
        }

        if(isset($_REQUEST['job_Responsibilities']))
        {
            $job_Responsibilities = $_REQUEST['job_Responsibilities'];
        }

        if(isset($_REQUEST['job_Benefits']))
        {
            $job_Benefits = $_REQUEST['job_Benefits'];
        }

        if(isset($_REQUEST['terms']))
        {
            $terms = $_REQUEST['terms'];
        }

        if(isset($_REQUEST['hdnJobId']))
        {
            $hdnJobId = $_REQUEST['hdnJobId'];
        }

        if(isset($_REQUEST['combinedQuestions']))
        {
            $combinedQuestions = $_REQUEST['combinedQuestions'];
            $combinedQuestionArray = explode('###', $combinedQuestions);
        }

        $this->result = DB::update("UPDATE 
                                        `recruit_jobpostings` 
                                    SET
                                        company_id = :company_id,
                                        job_title = :job_title,
                                        jobType = :jobType,
                                        minSalary = :minSalary,
                                        maxSalary = :maxSalary,
                                        industry = :industry,
                                        workFromHome = :workFromHome,
                                        resumeRequired = :resumeRequired,
                                        additionalDocs = :additionalDocs,
                                        additionalLinks = :additionalLinks,
                                        job_description = :job_description,
                                        job_Responsibilities = :job_Responsibilities,
                                        job_Benefits = :job_Benefits,
                                        terms =:terms,
                                        updated_date = :updated_date
                                    WHERE 
                                        id = :id", 
                                    [
                                        "company_id" =>$company_id,
                                        "job_title" =>$job_title, 
                                        "jobType" => $jobType,
                                        "minSalary" => $minSalary,
                                        "maxSalary" => $maxSalary,
                                        "industry" => $industry,
                                        "workFromHome" => $workFromHome,
                                        "resumeRequired" => $resumeRequired,
                                        "additionalDocs" => $additionalDocs,
                                        "additionalLinks" => $additionalLinks,
                                        "job_description" => $job_description,
                                        "job_Responsibilities" => $job_Responsibilities,
                                        "job_Benefits" => $job_Benefits,
                                        "terms" => $terms,
                                        "updated_date" => $modifiedDate,
                                        "id" => $hdnJobId]
                                ); 
        
        if(!empty($combinedQuestionArray))
        {
            $modifiedDate = date('Y-m-d h:i:s');
        $this->result = DB::delete("DELETE FROM recruit_jobpostings_questions WHERE jobID = ".$hdnJobId." ");
        foreach($combinedQuestionArray as $key=>$value)
        {    if($value !='')
                {
                    $result = DB::table('recruit_jobpostings_questions')->insertGetId(
                        [
                            'jobID'=> $hdnJobId , 
                            'questionName' => $value,
                            'created_by'=>$this->user_id,
                            'updated_date'=>$modifiedDate
                        ]
                    );
                }
            }
        }

        $returnData = array();
        return Reply::successWithData(__('messages.Recruit.JobUpdated'),['data' => $returnData]);
        exit();

    }

    public function deleteJob(Request $request)
    {
        $id = $_REQUEST['id'];

        $affected = DB::table('recruit_jobpostings')
        ->where('id', $id)
        ->update(['deleted_date' => \Carbon\Carbon::now()]);
            $returnData = array();
        return Reply::successWithData(__('messages.Recruit.jobDeleted'),['data' => $returnData]);

    }

    public function manageQuestions($id)
    {
        $this->jobID = $id;
        $this->jobQuestions = DB::select("  SELECT 	
                        a.id,
                        a.jobID,
                        a.questionName,
                        a.created_date,
                        b.job_title
                    FROM
                        recruit_jobpostings_questions a 
                    JOIN
                        recruit_jobpostings b
                    ON
                        a.jobID = b.id
                    WHERE
                        a.deleted_date IS NULL
                    AND
                        a.jobID = ".$id."
                    ");
        return view('admin.recruit.manageQuestions', $this->data);
        
    }

    public function createQuestion($id)
    {
       $this->jobID = $id;
       return view('admin.recruit.createQuestion', $this->data);
    }

    public function saveQuestion(Request $request)
    {
        echo '<pre>';
        print_r($_REQUEST);
        echo '</pre>';
        return;
    }

    public function profilelist($id)
    {
        $this->jobID = $id;
        $this->jobAnswers = DB::select("  SELECT 	
                        *
                    FROM
                        recruit_jobpostings_answers

                    WHERE
                    
                       jobapplication_id = ".$id."
                    ");
        return view('admin.recruit.profilelist', $this->data);
        
    }

    public function profileview($id)
    {
        $this->jobID = $id;
        $this->jobAnswers = DB::select("  SELECT 	
                        *
                    FROM
                        recruit_jobpostings_answers

                    WHERE
                    
                       id = ".$id."
                    ");
        $this->answers = DB::select("SELECT 
                                a.questionID,
                                b.questionName,
                                a.answer
                            FROM
                                recruit_jobpostings_questions_answers a
                            JOIN
                                recruit_jobpostings_questions b
                            ON
                                a.questionID = b.id
                            WHERE
                                a.jobposting_answer_id = ".$id." ");
                                
        return view('admin.recruit.profileview', $this->data);
    }


    public function mediaLinks(Request $request)
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $this->mediaLinks = DB::select('
        SELECT
            *
        FROM
            `company_socialmedialinks` WHERE company_id =  '.$this->company_id.'');

        return view('admin.recruit.addMediaLinks', $this->data);
    }

    public function saveMedialinks(Request $request)
    {
        $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $facebookLink = '';
        $twitterLink = '';
        $instramLink = '';
        
        
        $pixels = '';


        if(isset($_REQUEST['facebookLink']))
        {
            $facebookLink = addslashes($_REQUEST['facebookLink']);
        }

        if(isset($_REQUEST['twitterLink']))
        {
            $twitterLink = addslashes($_REQUEST['twitterLink']);
        }

        if(isset($_REQUEST['instramLink']))
        {
            $instramLink = $_REQUEST['instramLink'];
        }


        $deleteQuery = DB::delete('DELETE FROM company_socialmedialinks where company_id = "'.$this->company_id.'" ');
        
        $settingID = DB::table('company_socialmedialinks')->insertGetId(
            ['company_id'=> $this->company_id , 'facebook' => $facebookLink , 'twitter'=>$twitterLink , 'instagram' => $instramLink]);


        $returnData = array();
        return Reply::successWithData(__('messages.recruit.medialinkssaved'),['data' => $returnData]);
        exit();

    }

    public function updateMedialinks(Request $request)
    {
         $user = Auth::user();
        $this->user_id     = $user->id;
        $this->company_id = $user->company_id;

        $facebookLink = '';
        $twitterLink = '';
        $instramLink = '';
        
        
        $pixels = '';


        if(isset($_REQUEST['facebookLink']))
        {
            $facebookLink = addslashes($_REQUEST['facebookLink']);
        }

        if(isset($_REQUEST['twitterLink']))
        {
            $twitterLink = addslashes($_REQUEST['twitterLink']);
        }

        if(isset($_REQUEST['instramLink']))
        {
            $instramLink = $_REQUEST['instramLink'];
        }
        if(isset($_REQUEST['hdnSettingID']))
        {
            $settingID = $_REQUEST['hdnSettingID'];
        }

        


        $this->result = DB::update("UPDATE `company_socialmedialinks` 
                                                        SET 
                                                        company_id = :company_id ,
                                                        facebook = :facebook,
                                                        `twitter` = :twitter,
                                                        instagram = :instagram
                                                        WHERE 
                                                            id = :id", [
                                                                            "company_id" =>$this->company_id, 
                                                                            "facebook"=>$facebookLink,
                                                                            'twitter'=>$twitterLink,
                                                                            'instagram'=>$instramLink,
                                                                            "id" => $settingID]); 
        $returnData = array();
        return Reply::successWithData(__('messages.recruit.medialinksupdated'),['data' => $returnData]);
        exit();

    }
    

    
    

    

}                         
