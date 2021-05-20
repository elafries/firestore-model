<?php

namespace FirestoreModel;

use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Hashing\BcryptHasher;
use Kreait\Firebase\Firestore;
use ReflectionClass;
use function implode;
use function is_null;
use function lcfirst;
use function preg_match_all;
use function strtolower;
use function strtoupper;

abstract class FirestoreCollection
{
    protected ?string $table = null;

    public function __construct(
        protected Firestore $firestore,
        protected BcryptHasher $bcryptHasher
    ) {
        $this->setTable();
    }

    protected function setTable()
    {
        if (is_null($this->table)) {
            $reflect = new ReflectionClass($this);
            $this->table = $reflect->getShortName() . 's';
        }
    }

    public function getDatabase(): FirestoreClient
    {
        return $this->firestore->database();
    }

    public function getCollectionName(): string
    {
        preg_match_all(
            '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!',
            $this->table,
            $matches
        );
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    public function getCollection(): CollectionReference
    {
        return $this->getDatabase()->collection($this->getCollectionName());
    }
}
