<?php

namespace Elafries\FirestoreModel;

use Elafries\FirestoreModel\Queries\Delete;
use Elafries\FirestoreModel\Queries\Fetch;
use Elafries\FirestoreModel\Queries\Store;
use Elafries\FirestoreModel\Queries\Update;
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

    protected array $hidden = [];
    protected array $secure = [];
    protected array $fillable = [];


    protected function getSecureReadItem(array $item)
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


    protected function getSecureWriteItem(array $item): array
    {
        return array_reduce(array_keys($item), function ($accumulator, $currentKey) use ($item) {
            if (in_array($currentKey, $this->secure)) {
                $accumulator[$currentKey] = $this->bcryptHasher->make($item[$currentKey]);
            }
            $validKeys = array_merge($this->fillable, ['id']);
            if (in_array($currentKey, $validKeys)) {
                $accumulator[$currentKey] = $item[$currentKey];
            }
            return $accumulator;
        }, []);
    }
}
