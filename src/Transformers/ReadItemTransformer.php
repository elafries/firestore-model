<?php

namespace Elafries\FirestoreModel\Transformers;

use function array_keys;
use function array_reduce;
use function in_array;
use function sort;

trait ReadItemTransformer
{
    public function getSecureReadItem(array $item)
    {
        $itemKeys = array_keys($item);
        sort($itemKeys);
        return array_reduce($itemKeys, function ($accumulator, $currentKey) use ($item) {
            if (
                !in_array($currentKey, $this->hidden) &&
                (
                    in_array($currentKey, $this->fillable) ||
                    $currentKey === 'id'
                )
            ) {
                $accumulator[$currentKey] = $item[$currentKey];
            }
            return $accumulator;
        }, []);
    }

}