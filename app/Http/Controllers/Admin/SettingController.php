<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('Configuraçoes', 'Gerenciar configuraçoes');
        return view('admin.settings.index');
    }


}
