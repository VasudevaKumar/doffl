<?php

namespace App\Http;

use App\Http\Middleware\AccountSetup;
use App\Http\Middleware\CheckInstaller;
use App\Http\Middleware\LicenceExpire;
use App\Http\Middleware\LicenseExpireDateWise;
use App\Http\Middleware\SuperAdmin;
use App\Http\Middleware\CheckPlan;
use App\Http\Middleware\FilesLimit;
use App\Http\Middleware\ChatLimit;
use App\Http\Middleware\PushLimit;
use App\Http\Middleware\SurveysLimit;
use App\Http\Middleware\BookingsLimit;
use App\Http\Middleware\EmployeeLimit;
use App\Http\Middleware\PaymentLinksLimit;
use App\Http\Middleware\ShortUrlsLimit;
use App\Http\Middleware\StorageLimit;
use App\Http\Middleware\CheckBills;
use App\Http\Middleware\RecruitLimit;
use App\Http\Middleware\KnowledgeBase;


use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
			//\Barryvdh\Cors\HandleCors::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        'role' => \Trebol\Entrust\Middleware\EntrustRole::class,
        'permission' => \Trebol\Entrust\Middleware\EntrustPermission::class,
        'ability' => \Trebol\Entrust\Middleware\EntrustAbility::class,
        'cors' => \Barryvdh\Cors\HandleCors::class,
        'super-admin' => SuperAdmin::class,
        'check-install' => CheckInstaller::class,
        'account-setup' => AccountSetup::class,
        'license-expire' => LicenseExpireDateWise::class,
        'check-plan'    => CheckPlan::class,
        'files-limit'    => FilesLimit::class,
        'chat-limit'    => ChatLimit::class,
        'push-limit'    => PushLimit::class,
        'surveys-limit'    => SurveysLimit::class,
        'bookings-limit'    => BookingsLimit::class,
        'employee-limit'    => EmployeeLimit::class,
        'payments-limit'    => PaymentLinksLimit::class,
        'shorturls-limit'    => ShortUrlsLimit::class,
        'storage-limit'    => StorageLimit::class,
        'check-bills'    => CheckBills::class,
		'recruit-limit'    => RecruitLimit::class,
		'kb-limit'    => KnowledgeBase::class,
    ];
}
