<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreProjectCategory;
use Illuminate\Support\Facades\DB;
use Auth;


class SurveyPageController extends MemberBaseController
{
    //

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.surveys';
        $this->pageIcon = 'fa fa-file';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function displaySurveys()
    {

        // $userID = request()->get('userID');
        $user = Auth::user();

        $this->user_id     = $user->id;
        return view('member.survey-pages.display', $this->data);

    }

}
