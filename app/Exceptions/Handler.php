<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof ModelNotFoundException){
            $modelName = strtolower(class_basename($exception->getModel()));

            return response()->json(["Não existe {$modelName} com essa identificação"], 404);
        }

        if ($exception instanceof AuthorizationException){
            return response()->json([$exception->getMessage()], 403);
        }

        if ($exception instanceof MethodNotAllowedHttpException){
            return response()->json(["O método requisitado é invalido"], 405);
        }

        if ($exception instanceof NotFoundException){
            return response()->json(["A URL espeficiada não existe"], 404);
        }

        if ($exception instanceof HttpException){
            return response()->json([$exception->getMessage()], $exception->getStatusCode());
        }

        if ($exception instanceof QueryException){
            $errorCode = $exception->errorInfo[1];
            if ($errorCode == 1451){
                return response()->json(["
não pode remover este recurso permanentemente. Está relacionado com qualquer outro recurso"], 409);
            }
            
        }
    
        if (config('app.debug')){
            return parent::render($request, $exception);
        }

        return response()->json(['error' => 'Exceção não esperada', 'exception' => $exception], 500);
    }
}
