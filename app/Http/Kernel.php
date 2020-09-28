<?php

namespace App\Http;

use App\Http\Middleware\AnswerInSurvey;
use App\Http\Middleware\AnswerValidator;
use App\Http\Middleware\ElementInMatrixQuestionMiddleware;
use App\Http\Middleware\EmailInInvitationPool;
use App\Http\Middleware\InputQuestionMiddleware;
use App\Http\Middleware\InvitationPoolInSurvey;
use App\Http\Middleware\MatrixQuestionInQuestionGroupMiddleware;
use App\Http\Middleware\MultiQuestionMiddleware;
use App\Http\Middleware\OptionInMultiQuestionMiddleware;
use App\Http\Middleware\SurveyActivationVerification;
use App\Http\Middleware\SurveyQuestionMiddleware;
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
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Fruitcake\Cors\HandleCors::class,
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
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
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'qg.in.survey' => SurveyQuestionMiddleware::class,
        'inputquestion.in.qg' => InputQuestionMiddleware::class,
        'multiquestion.in.qg' => MultiQuestionMiddleware::class,
        'option.in.question' => OptionInMultiQuestionMiddleware::class,
        'matrixquestion.in.qg' => MatrixQuestionInQuestionGroupMiddleware::class,
        'element.in.matrix' => ElementInMatrixQuestionMiddleware::class,
        'invitation_pool.in.survey' => InvitationPoolInSurvey::class,
        'email.in.invitation_pool' => EmailInInvitationPool::class,
        'answer.in.survey' => AnswerInSurvey::class,
        'survey.activation.verification' => SurveyActivationVerification::class,
        'answer.validator' => AnswerValidator::class,
    ];
}
