<?php

namespace Tests\FirestoreModel\Transformers\ReadItemTransformer;

use Monolog\Test\TestCase;

class ReadItemTransformerTest extends TestCase
{
    private ReadItemTransformerModel $model;

    public function setUp(): void
    {
        $this->model = new ReadItemTransformerModel();
    }

    public function test_on_empty_items()
    {
        $response = $this->model->getSecureReadItem([]);
        $this->assertEmpty($response);
    }

    public function test_on_fillable_item()
    {
        $response = $this->model->getSecureReadItem(['name' => 'asd']);

        $this->assertCount(1, $response);
    }

    public function test_on_fillable_item_with_a_non_fillable_item()
    {
        $response = $this->model->getSecureReadItem(['name' => 'asd', 'jozsi' => '2a']);

        $this->assertCount(1, $response);
    }

    public function test_on_id()
    {
        $response = $this->model->getSecureReadItem(['id' => '2a']);
        $this->assertCount(1, $response);
    }

    public function test_on_hidden_item()
    {
        $response = $this->model->getSecureReadItem(['password' => 'asd']);
        $this->assertEmpty($response);
    }
}