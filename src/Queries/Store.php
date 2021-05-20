<?php

namespace Elafries\FirestoreModel\Queries;

trait Store
{
    public function create(array $data): array
    {
        $document = $this->getCollection()->newDocument();

        $document->set($this->getSecureWriteItem($data));
        $data['id'] = $document->id();

        return $this->getSecureReadItem($data);
    }

}
