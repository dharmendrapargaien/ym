<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use League\OAuth2\Server\Exception\InvalidRequestException;
use League\OAuth2\Server\Exception\InvalidCredentialsException;

class Handler extends ExceptionHandler
{
    public $jsonResponse  = ['status' => 'fail'];

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    

    /**
    * Render an exception into an HTTP response.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Exception  $e
    * @return \Illuminate\Http\Response
    */
   public function render($request, Exception $e)
   {
      // if($e instanceof TokenMismatchException)
      //     return $this->handleTokenMismatch();

      return parent::render($request, $e);
      if($e instanceof HttpResponseException)
        return parent::render($request, $e);
        
      if($e instanceof ValidationException)
        return parent::render($request, $e);

      if ($e instanceof ModelNotFoundException) {
        
        return $this->setRender($request, $e, 404,  ['error' => 'Application not found']);
      }

      if($e instanceof NotFoundHttpException) {
        
        return $this->setRender($request, $e, 404,  ['error' => 'Page not found']);
      }

      if($e instanceof InvalidRequestException) {

        return $this->setRender($request, $e, 400, ['error' => 'Please provide password and email']);
      }

      if($e instanceof InvalidCredentialsException) {
        
        return $this->setRender($request, $e, 401, ['error' => 'Please enter a valid credentials.']);
      }
      // if ($e instanceof UnauthorizedException) {
      //     return $this->setRender($request, $e, 401,  ['error' => 'You are not authorized']);
      // }

      return $this->setRender($request, $e);
   }

   /**
    * Function does error handling according to request type and enviornment
    * @param Request  $request 
    * @param Exception  $e       
    * @param integer $status  [status code]
    * @param array   $message [message array of json return]
    */
   public function setRender($request, $e, $status = 500, $message = ['error' => 'Server Error'])
   {
       //case when eviournment is not local
       //when request was ajax type
       if($request->ajax() || $request->wantsJson()){

           //getting the stacktrace when in local else returning the message intended
           $message = (env('APP_ENV') === 'local' || env('APP_ENV') === 'dev') ? $e->__toString() : $message;

           //if api request for websystem
           // if($request->is('api/*')){
           //     $apiResponse = new \EllipseSynergie\ApiResponse\Laravel\Response(new \League\Fractal\Manager);
           //     $apiResponse->setStatusCode($status);
           //     return $apiResponse->withError($message, $status);
           // }

           //else sending the default json response
           $this->jsonResponse['errors'] = $message;
           return response()->json($this->jsonResponse, $status);
       }

       //if env is local
       if(env('APP_ENV') === 'local' || env('APP_ENV') === 'dev')
           return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);

       $e = new HttpException($status, $e->getMessage());
       return $this->renderHttpException($e);
   }

   /**
    * Handle token mismatch exception
    * @return redirect 
    */
   // private function handleTokenMismatch()
   // {
   //     \AppHelper::setFlashMessage('error', 'Either your session has expired or cross site forgery token has expired.');
   //     return redirect()->back();
   // }

}
