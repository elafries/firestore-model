<?php

namespace Tests\FirestoreModel\Transformers;

use Elafries\FirestoreModel\Transformers\ReadItemTransformer;
use Illuminate\Hashing\BcryptHasher;
use Kreait\Firebase\Firestore;
use Monolog\Test\TestCase;

class Model {
    use ReadItemTransformer;
}

class ReadItemTransformerTest extends TestCase
{
    private Model $model;

    public function setUp(): void
    {
        $this->model = new Model();
    }

    public function test_on_empty_item()
    {
        $response = $this->model->getSecureReadItem([]);
        $this->assertEmpty($response);
    }
}