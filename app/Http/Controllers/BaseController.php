<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\FlashMessages;

class BaseController extends Controller
{
    use FlashMessages;

    /**
     *
     * @var null
     */
    protected $data = null;

    /**
     * método define titulo e subtitulo da pagina
     * @param string $title
     * @param string $subTitle
     */
    protected function setPageTitle($title, $subTitle)
    {
        view()->share(['pageTitle' => $title,'subTitle' => $subTitle]);
    }

    /**
     *
     * @param  integer $error
     * @param  string  $message [description]
     * @return response
     */
    protected function showErrorPage($error = 404, $message = null)
    {
        $data['message'] = $message;

        response()->view('errors.'.$errorCode, $data, $errorCode);
    }

    /**
     * @param boolean $error
     * @param int $responseMessage
     * @param string $message
     * @param array $message
     * @param array $data
     */
    protected function responseJson($error = true, $responseCode = 200, $message = [], $data = null)
    {
        return response()->json([
            'error' => $error,
            'responese_code' => $responseCode,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function responseRedirect($route, $message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();
        return redirect()->back();

    }
}
