<?php

namespace App\Exceptions;

use Illuminate\Contracts\Queue\EntityNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Rickycezar\Impersonate\Exceptions\CantBeImpersonatedException;
use Rickycezar\Impersonate\Exceptions\CantImpersonateException;
use Rickycezar\Impersonate\Exceptions\CantImpersonateSelfException;
use Rickycezar\Impersonate\Exceptions\ProtectedAgainstImpersonationException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        $notReported = [
            ValidationException::class,
            EntityNotFoundException::class,
        ];

        $className = get_class($e);

        if (in_array($className, $notReported)) {
            return;
        }

        parent::report($e);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if($exception instanceof ValidationException){
            $errors = $exception->validator->errors()->getMessages();

            return response()->json([
                'error' => true,
                'message' => "Preencimento de campos incorreto",
                'errors' => $errors,
            ]);

        }
        if (env('APP_DEBUG') == false) {
            if ($exception instanceof ClientException) {
                return response()->json([
                    'error' => true,
                    'message' => $exception->getMessage(),
                ]);
            }
        }
        return parent::prepareJsonResponse($request, $exception);
    }
}
