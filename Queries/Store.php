<?php

namespace App\Modules\FirestoreModel\Queries;

use function array_reduce;
use function in_array;

trait Store
{
    public function create(array $data): array
    {
        $document = $this->getCollection()->newDocument();

        $document->set($this->getSecureItemToCreate($data));
        $data['id'] = $document->id();

        return $this->getSecureItem($data);
    }

    protected function getSecureItemToCreate(array $item): array
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
