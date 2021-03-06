<?php

namespace Elafries\FirestoreModel\Queries;

use function array_keys;

trait Update
{
    public function updateById(string $id, array $updateValues): void
    {
        $document = $this->getCollection()->document($id);

        $document->update($this->getUpdateItem($updateValues));
    }

    public function update(array $updateValues): void
    {
        $documents = $this->query->documents();
        $this->query = null;

        foreach ($documents as $document) {
            if ($document->exists()) {
                $this->updateById($document->id(), $updateValues);
            }
        }
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