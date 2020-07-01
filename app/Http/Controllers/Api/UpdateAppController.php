<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;

class UpdateAppController extends Controller
{
    /**
     * @param \App\Models\App $app
     * @return \App\Models\App
     */
    public function __invoke(App $app)
    {
        $this->authorize('view', $app);

        return $app->load('variables');
    }
}
