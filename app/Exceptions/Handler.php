<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register ()
    {
        $this->reportable (function (Throwable $e) {
            //
        });
    }
    public function render ($request, Throwable $e){
        if ( $e instanceof  ValidationException){
            $msg = Arr::first (Arr::collapse ($e->errors ()));
            return ajax_error_result ($msg);
        }elseif($e instanceof BusinessException){
            $msg = $e->getMessage ();
            return ajax_error_result ($msg);
        }
        return parent::render ($request, $e);
    }
}
