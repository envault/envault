<?php

namespace Tests\Unit;

use App\Models\App;
use App\Models\Variable;
use App\Models\VariableVersion;
use Tests\TestCase;

class VariableTest extends TestCase
{
    /** @test */
    public function latest_version_retrieved()
    {
        $app = factory(App::class)->create();

        $variable = $app->variables()->create(factory(Variable::class)->make()->toArray());

        $variableVersion = $variable->versions()->create(factory(VariableVersion::class)->make()->toArray());

        $this->assertEquals($variable->latest_version->id, $variableVersion->id);
    }
}
