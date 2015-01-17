<?php

namespace Yaro\Mecha;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;


class Mecha
{

    public function render()
    {
        $isAuthorized = Config::get('mecha::auth_check');
        if (!Config::get('mecha::is_auth_by_credentials') || $isAuthorized()) {
            $skip = \Config::get('mecha::skip', array());
            return View::make('mecha::mecha', compact('skip'));
        }

        return View::make('mecha::login');
    } // end render


}

