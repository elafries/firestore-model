<?php

namespace Elafries\FirestoreModel;

use Elafries\FirestoreModel\Queries\Delete;
use Elafries\FirestoreModel\Queries\Fetch;
use Elafries\FirestoreModel\Queries\Store;
use Elafries\FirestoreModel\Queries\Update;
use Elafries\FirestoreModel\Transformers\ReadItemTransformer;
use Elafries\FirestoreModel\Transformers\WriteItemTransformer;
use function array_keys;
use function array_merge;
use function array_reduce;
use function in_array;

abstract class FirestoreModel extends FirestoreCollection
{
    use Fetch;
    use Store;
    use Delete;
    use Update;
    use ReadItemTransformer;
    use WriteItemTransformer;

    protected array $hidden = [];
    protected array $secure = [];
    protected array $fillable = [];
}
