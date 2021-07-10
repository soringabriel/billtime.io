<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class GeneralException.
 */
class GeneralException extends Exception
{
    /**
     * @var
     */
    public $message;

    /**
     * GeneralException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        activity('exception')
            ->withProperties(hashRequestPasswords($request))
            ->log($this->message);

        // All instances of GeneralException redirect back with a flash message to show a bootstrap alert-error
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'errors' => ['message' => $this->message],
            ]);
        }
        return redirect()
            ->back()
            ->withInput()
            ->withFlashDanger($this->message);
    }
}
