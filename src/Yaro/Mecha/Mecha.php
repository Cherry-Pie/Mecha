<?php

namespace Yaro\Mecha;


class Mecha
{

    public function render()
    {
        $isAuthorized = config('yaro.mecha.auth_check');
        if (!config('yaro.mecha.is_auth_by_credentials') || $isAuthorized()) {
            $skip = config('yaro.mecha.skip', []);
            return view('mecha::mecha', compact('skip'));
        }

        return view('mecha::login');
    } // end render

}
