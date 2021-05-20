<?php

namespace Elafries\FirestoreModel\Queries;

use Google\Cloud\Firestore\Query;

trait Fetch
{
    protected ?Query $query = null;

    public function where($fieldPath, $operator, $value): self
    {
        if (is_null($this->query)) {
            $this->query = $this->getCollection()->where($fieldPath, $operator, $value);
        } else {
            $this->query = $this->query->where($fieldPath, $operator, $value);
        }
        return $this;
    }

    public function findByIdRaw(string $id): array
    {
        $item = $this->getCollection()
            ->document($id)
            ->snapshot()
            ->data();
        $item['id'] = $id;

        return $item;
    }

    public function findById(string $id): array
    {
        return $this->getSecureReadItem(
            $this->findByIdRaw($id)
        );
    }

    public function count(): int
    {
        $documents = $this->query->documents();
        $this->query = null;
        return $documents->size();
    }

    public function exists(): bool
    {
        $documents = $this->query->documents();
        $this->query = null;
        return !$documents->isEmpty();
    }

    public function getRaw(): array
    {
        $documents = $this->query->documents();
        $this->query = null;
        $response = [];

        foreach ($documents as $document) {
            if ($document->exists()) {
                $response [] = $this->findByIdRaw($document->id());
            }
        }
        return $response;
    }

    public function get(): array
    {
        return array_map(
            function ($item) {
                return $this->getSecureReadItem($item);
            },
            $this->getRaw()
        );
    }

    public function firstRaw(): ?array
    {
        $documents = $this->query->documents();
        $this->query = null;

        foreach ($documents as $document) {
            if ($document->exists()) {
                return $this->findByIdRaw($document->id());
            }
        }
        return null;
    }

    public function first(): ?array
    {
        $item = $this->firstRaw();
        if (!is_null($item)) {
            return $this->getSecureReadItem($item);
        }
        return null;
    }

    public function all(): array
    {
        $this->query = $this->getCollection();
        return $this->get();
    }
}
