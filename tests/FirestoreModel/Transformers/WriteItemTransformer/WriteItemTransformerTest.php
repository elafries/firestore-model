<?php

namespace Tests\FirestoreModel\Transformers\WriteItemTransformer;

use Illuminate\Hashing\BcryptHasher;
use Monolog\Test\TestCase;

const HASHED_PASSWORD = 'hashed';

class WriteItemTransformerTest extends TestCase
{
    private WriteItemTransformerModel $model;

    public function setUp(): void
    {
        $this->model = new WriteItemTransformerModel($this->getBcryptHasherMock());
    }

    public function test_on_empty_items()
    {
        $response = $this->model->getSecureWriteItem([]);
        $this->assertEmpty($response);
    }

    public function test_on_fillable_item()
    {
        $response = $this->model->getSecureWriteItem(['name' => 'test']);
        $this->assertCount(1, $response);
    }

    public function test_on_id()
    {
        $response = $this->model->getSecureWriteItem(['id' => '2s']);
        $this->assertCount(1, $response);
    }


    public function test_on_secure()
    {
        $response = $this->model->getSecureWriteItem(['password' => 'asdfasdf']);
        $this->assertCount(1, $response);
        $this->assertEquals(HASHED_PASSWORD, $response['password']);
    }

    public function getBcryptHasherMock(): BcryptHasher
    {
        $bcryptHasher = $this->createMock(BcryptHasher::class);
        $bcryptHasher->method('make')->willReturn(HASHED_PASSWORD);
        return $bcryptHasher;
    }
}