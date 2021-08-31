<?php

declare(strict_types=1);

namespace Deligoez\LaravelModelHashIDs\Tests\Traits;

use Deligoez\LaravelModelHashIDs\Tests\Models\ModelA;
use Deligoez\LaravelModelHashIDs\Tests\Models\ModelB;
use Deligoez\LaravelModelHashIDs\Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Route;

class HasHasIDRoutingTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_can_resolve_a_hashID_via_route_model_binding(): void
    {
        // 1️⃣ Arrange 🏗
        ModelA::factory()->count($this->faker->numberBetween(2, 5))->create();
        $model = ModelA::factory()->create(['name' => 'model-that-should-bind']);
        $hashID = $model->hashID;

        Route::get('/model-a/{modelA}', function (ModelA $modelA) {
            return $modelA->toJson();
        })->middleware('bindings');

        // 2️⃣ Act 🏋🏻‍
        $response = $this->getJson("/model-a/{$hashID}");

        // 3️⃣ Assert ✅
        $response
            ->assertOk()
            ->assertJsonFragment([
                'id'   => $model->getKey(),
                'name' => 'model-that-should-bind',
            ]);
    }
}
