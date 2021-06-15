<?php

namespace Tests\FirestoreModel\Transformers\WriteItemTransformer;

use Elafries\FirestoreModel\Transformers\WriteItemTransformer;
use Illuminate\Hashing\BcryptHasher;

class WriteItemTransformerModel
{
    use WriteItemTransformer;

    public function __construct(protected BcryptHasher $bcryptHasher)
    {
    }

    protected $fillable = ['name', 'email'];
    protected $hidden = ['password'];
    protected $secure = ['password'];
}