<?php

namespace Elafries\FirestoreModel\Queries;

use function array_keys;

trait Update
{
    public function updateById(string $id, array $updateValues): void
    {
        $document = $this->getCollection()->document($id);
        $updatableItem = $document->snapshot()->data();

        foreach ($updateValues as $key => $updateValue) {
            $updatableItem[$key] = $updateValue;
        }

        $document->update($this->getUpdateItem($updatableItem));
    }

    protected function getUpdateItem(array $item): array
    {
        $secureItem = $this->getSecureWriteItem($item);

        return array_map(function ($propertyKey) use ($secureItem) {
            return [
                'path' => $propertyKey, 'value' => $secureItem[$propertyKey]
            ];
        }, array_keys($secureItem));
    }
}