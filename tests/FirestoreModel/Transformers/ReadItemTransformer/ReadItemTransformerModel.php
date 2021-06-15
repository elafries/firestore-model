<?php

namespace Tests\FirestoreModel\Transformers\ReadItemTransformer;

use Elafries\FirestoreModel\Transformers\ReadItemTransformer;

class ReadItemTransformerModel
{
    use ReadItemTransformer;

    protected $fillable = ['name', 'email'];
    protected $hidden = ['password'];
}