<?php

namespace App\Http\Controllers\Api;

use App\App;
use App\Http\Controllers\Controller;

class UpdateAppController extends Controller
{
    /**
     * @param \App\App $app
     * @return \App\App
     */
    public function __invoke(App $app)
    {
        return $app->load('variables');
    }
}
