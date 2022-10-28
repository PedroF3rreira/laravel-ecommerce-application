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
}
