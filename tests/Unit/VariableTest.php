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
        $app = App::factory()->create();

        $variable = $app->variables()->create(Variable::factory()->make()->toArray());

        $variableVersion = $variable->versions()->create(VariableVersion::factory()->make()->toArray());

        $this->assertEquals($variable->latest_version->id, $variableVersion->id);
    }
}
