<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;

class SetupAppController extends Controller
{
    /**
     * @param \App\Models\App $app
     * @param string $token
     * @return array
     */
    public function __invoke(App $app, $token)
    {
        $setupToken = $app->setup_tokens()->where([
            ['created_at', '>=', now()->subMinutes(10)],
            ['token', $token],
        ])->firstOrFail();

        if ($setupToken->user->cannot('view', $app)) {
            abort(403);
        }

        return [
            'authToken' => $setupToken->user->createToken(uniqid())->plainTextToken,
            'app' => $setupToken->app->load('variables'),
        ];
    }
}
