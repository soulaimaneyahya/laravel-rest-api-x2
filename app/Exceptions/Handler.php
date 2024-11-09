<?php

namespace App\Exceptions;

// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'remember_token',
        'email_verified_at',
        'verification_token',
        'api_token',
        'deleted_at',
        \App\Models\User::VERIFIED_STATUS,
        \App\Models\User::ROLE,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // 401
        $this->renderable(function (UnauthorizedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return $this->infoResponse("Unauthorized", 401);
            }
        });
        // 401
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return $this->infoResponse("Unauthenticated", 401);
            }
        });
        
        // 403
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return $this->infoResponse("Access Denied", 403);
            }
        });
        
        // 404
        $this->renderable(function (NotFoundHttpException $e, $request) {
            $modelName = strtolower(class_basename($e->getPrevious()->getModel()));
            $id = $e->getPrevious()->getIds()[0];

            if ($request->is('api/*')) {
                return $this->infoResponse(
                    "Does not exists any {$modelName} with the specified {$id}",
                    404
                );
            }
        });
        
        // 405
        $this->renderable(function (MethodNotAllowedException $e, $request) {
            if ($request->is('api/*')) {
                return $this->infoResponse('The specified method for the request is invalid', 405);
            }
        });
        
        // $e->getStatusCode()
        $this->renderable(function (HttpException $e, $request) {
            return $this->infoResponse($e->getMessage(), $e->getStatusCode());
        });

        // 409
        $this->renderable(function (QueryException $e, $request) {
            if ($request->is('api/*')) {
                $errorCode = $e->errorInfo[1];

                if ($errorCode == 1451) {
                    return $this->infoResponse('Cannot remove this resource permanently. It is related with any other resource', 409);
                }
            }
        });

        // other expected exceptions
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                if (config('app.debug')) {
                    return $this->infoResponse($e->getMessage(), 500);
                }
                return $this->infoResponse("Unexpected Exception. Try Later", 500);
            }
        });
    }
}
