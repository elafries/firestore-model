<?php

namespace Elafries\FirestoreModel\Transformers;

use function array_keys;
use function array_merge;
use function array_reduce;
use function in_array;

trait WriteItemTransformer
{
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