<?php

namespace App\Http\Middleware;

use App\GlobalSetting;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;


class PaymentLinksLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(company()->package_id == 1){
			$user = auth()->user();
			$company_id = $user->company_id;

			$company = \App\Company::find($company_id);

				$package = \App\Package::find($company->package_id);

				$pack_config = json_decode($package->pack_config);

				$bills = \App\Bills::where('company_id', company()->id)->latest()->first();

				if($bills){
					$payments_count =  \App\PaymentLinksLog::where('company_id', company()->id)->where('click_time', '>', $bills->created_at)->count();

					if($pack_config->pay_link != "-1" && $pack_config->pay_link <= $payments_count){
						return redirect()->route('admin.billing');
					}
				}else{
					$payments_count = \App\PaymentLinksLog::where('company_id', company()->id)->where('click_time', '>', Carbon::now()->subDays(30))->count();

					if($pack_config->pay_link != "-1" && $pack_config->pay_link <= $payments_count){
						return redirect()->route('admin.billing');
					}
				}
		}

        
        return $next($request);
    }
}
