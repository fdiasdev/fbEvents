<?php

namespace Ingresse\Service;

use MongoDB;

class Storage
{
    private $db;

    public function __construct(MongoDB $db)
    {
        $this->db = $db;
    }

    public function getEvents($collection)
    {
        return $this->getDb()->$collection->find([]);
    }

    public function saveEvents($events, $collection)
    {
        $collection = $this->getDb()->$collection;
        $collection->drop();
        $collection->batchInsert($events);
    }

    public function getDb()
    {
        return $this->db;
    }
}