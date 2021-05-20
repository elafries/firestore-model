<?php

namespace App\Modules\FirestoreModel;

use App\Modules\FirestoreModel\Queries\Delete;
use App\Modules\FirestoreModel\Queries\Fetch;
use App\Modules\FirestoreModel\Queries\Store;

use function array_keys;
use function array_reduce;
use function in_array;

abstract class FirestoreModel extends FirestoreCollection
{
    use Fetch;
    use Store;
    use Delete;

    protected array $hidden = [];
    protected array $secure = [];
    protected array $fillable = [];


    protected function getSecureItem(array $item)
    {
        $itemKeys = array_keys($item);
        sort($itemKeys);
        return array_reduce($itemKeys, function ($accumulator, $currentKey) use ($item) {
            if (!in_array($currentKey, $this->hidden)) {
                $accumulator[$currentKey] = $item[$currentKey];
            }
            return $accumulator;
        }, []);
    }
}