<?php

namespace App\Http\Controllers\Front;

use App\Company;
use App\Helper\Reply;
use App\Http\Requests\Front\Register\StoreRequest;
use App\Notifications\EmailVerificationSuccess;
use App\Role;
use App\SeoDetail;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Session;

class RegisterController extends FrontBaseController
{
    public function index()
    {

        if (\user()) {
            return redirect(getDomainSpecificUrl(route('login'), \user()->company));
        }
        $this->seoDetail = SeoDetail::where('page_name', 'home')->first();
        $this->pageTitle = 'Sign Up';

        $view = ($this->setting->front_design == 1) ? 'saas.register' : 'front.register';

        return view($view, $this->data);
    }

    public function store(StoreRequest $request)
    {

        $company = new Company();

        if (!$company->recaptchaValidate($request)) {
            return Reply::error('Recaptcha not validated.');
        }

        DB::beginTransaction();
        try {
            $company->company_name = $request->company_name;
            $company->company_email = $request->email;
            $company->token = (string) Str::orderedUuid();

            if (module_enabled('Subdomain')) {
                $company->sub_domain = $request->sub_domain;
            }
            $company->save();

            $widget = new \App\WidgetCode;
            $widget->company_id = $company->id;
            $widget->save();
            
            $chat = new \App\ChatSettings;
            $chat->company_id = $company->id;
            $chat->domains    = $company->sub_domain;
            $chat->modified_by  = 0;
            $chat->save();
            
            $files = new \App\FilesSettings;
            $files->company_id = $company->id;
            $files->save();
    
            $config = new \App\PushConfig;
            $config->company_id = $company->id;
            $config->icon = "91bba0f8-1680-4b54-80ca-05d0865f1e51.jpg";
            $config->save();

            $user = $company->addUser($company, $request);
            $message = $company->addEmployeeDetails($user);
			
			$success = $message = __('messages.signUpThankYou') . '. Your login URL : '.$company->sub_domain.'/login';

            Session::put('loginUrl', 'https://'.$company->sub_domain.'/login');


            $company->assignRoles($user);
			
            DB::commit();
        } catch (\Swift_TransportException $e) {
            DB::rollback();
            return Reply::error('Please contact administrator to set SMTP details to add company', 'smtp_error');
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return Reply::error('Some error occurred when inserting the data. Please try again or contact support');
        }

        return Reply::success($success);
        // return view('front.thankyou', $this->data);
    }
	
	function resend(Request $request){
		$user = \App\User::where('email', $request->reverify_email)->first();
		
		if($user){
			$company = new Company();
			
			$message = $company->resend_verify($user);
			
			return Reply::success($message);
		}else{
			return Reply::error('Some error occurred when inserting the data. Please try again or contact support');
		}
	}
	
    public function getEmailVerification($code)
    {
        $this->pageTitle = 'modules.accountSettings.emailVerification';
        $this->message = User::emailVerify($code);
        return view('auth.email-verification', $this->data);
    }

    public function thankyou()
    {
        $this->pageTitle = 'Thank you';
        return view('front.thankyou', $this->data);
    }
}
