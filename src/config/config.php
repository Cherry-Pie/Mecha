<?php

return array(

    'dir_access' => function($root, $dir, $file) {
        return true; // false to deny
    },

    'file_access' => function($root, $dir, $file) {
        return true; // false to deny
    },

    'is_auth_by_credentials' => true,

    'auth_check' => function() {
        return \Session::get('mecha.is_auth', false);
    },

    'auth_callback' => function($login, $pass) {
        // Change me!
        if (md5(sha1($login)) == 'b7c550579ba9ada4e21c0d6d176f969e' && md5(sha1($pass)) == 'abad4419de9fa6f2f7519fa6fc0f6fe8') {
            \Session::put('mecha.is_auth', true);
            return true;
        }

        return false;
    },

    // which files skip while rendering
    'skip' => array(
        // 'jquery.js',
        // 'jquery-ui.js',
        // 'bootstrap.css',
        // 'jquery-ui.css',
        // 'bootstrap-theme.css',
        // 'font-awesome.css',
        // 'toastr.js',
        // 'toastr.css',
    ),

);
