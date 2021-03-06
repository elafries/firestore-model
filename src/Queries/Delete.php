<?php

namespace Elafries\FirestoreModel\Queries;

trait Delete
{
    public function delete(): void
    {
        $documents = $this->query->documents();
        $this->query = null;

        foreach ($documents as $document) {
            if ($document->exists()) {
                $this->getCollection()->document($document->id())->delete();
            }
        }
    }
}
