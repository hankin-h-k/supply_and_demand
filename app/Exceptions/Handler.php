<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        'password',
        'password_confirmation',
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
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['code'=>2, 'message' => '请登录后访问.'], 200);
        }

        return redirect()->guest(route('login'));
    }

    public function prepareJsonResponse($request, Exception $e)
    {
        $data['status'] = $this->isHttpException($e) ? $e->getStatusCode() : 500;
        if(config('app.debug')){
            $data['file'] = $e->getFile();
            $data['line'] = $e->getLine();
            $data['traces'] = $e->getTrace();
        }

        $headers = $this->isHttpException($e) ? $e->getHeaders() : [];
        $message = $e->getMessage();
        if ($message == 'The given payload is invalid.') {
            $message = '服务错误，请重试';
        }
        return new JsonResponse(
            [ 'code'=>1,
                'data'=>$data,
                'message'=>$data['status'].':'.$message
            ], 200, $headers,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
        
    }
}
