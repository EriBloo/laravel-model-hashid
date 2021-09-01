<?php

declare(strict_types=1);

namespace Deligoez\LaravelModelHashId\Tests\Mixins;

use Deligoez\LaravelModelHashId\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Deligoez\LaravelModelHashId\Tests\Models\ModelA;

class FindByHashIdMixinTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_find_a_model_by_its_hashID(): void
    {
        // 1️⃣ Arrange 🏗
        $model = ModelA::factory()->create();
        $hashID = $model->hashID;

        // 2️⃣ Act 🏋🏻‍
        $foundModel = ModelA::findByHashId($hashID);

        // 3️⃣ Assert ✅
        $this->assertTrue($model->is($foundModel));
    }

    /** @test */
    public function it_can_find_a_model_by_its_hashID_from_specific_columns(): void
    {
        // 1️⃣ Arrange 🏗
        $model = ModelA::factory()->create();
        $hashID = $model->hashID;
        $selectedColumns = ['id'];

        // 2️⃣ Act 🏋🏻‍
        $foundModel = ModelA::findByHashId($hashID, $selectedColumns);

        // 3️⃣ Assert ✅
        $this->assertTrue($model->is($foundModel));
    }

    /** @test */
    public function it_returns_null_if_can_not_find_a_model_with_given_hashID(): void
    {
        // 2️⃣ Act 🏋🏻‍
        $foundModel = ModelA::findByHashId('non-existing-hash-id');

        // 3️⃣ Assert ✅
        $this->assertNull($foundModel);
    }
}
