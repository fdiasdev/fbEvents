<?php

namespace Ingresse\Service;

use Ingresse\Consumer\Facebook as Consumer;
use Ingresse\Service\Storage as Storage;
use Facebook\FacebookSession as Session;
use MongoDB;

class Facebook
{

    private $params;

    private $session;

    private $consumer;

    private $storage;

    const COLLECTION_PREFIX = 'u';

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function getSession()
    {
        if ( null == $this->session ) {
            $this->session = $this->getConsumer()->requestSession();
        }
        return $this->session;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function getUrl()
    {
        return $this->getConsumer()->getUrl();
    }

    public function getProfile()
    {
        return $this->getConsumer()->getProfile($this->getSession());
    }

    public function getEventsStored($userId)
    {
        return $this->getStorage()->getEvents(self::COLLECTION_PREFIX . $userId);
    }

    public function searchAndSaveEvents()
    {
        try {
            $events  = $this->getConsumer()->getEvents($this->getSession());
            $profile = $this->getConsumer()->getProfile($this->getSession());
            $this->getStorage()->saveEvents(
                $events['data'], self::COLLECTION_PREFIX . $profile['id']
            );
            return true;
        } catch (Exception $e) {
            throw new Exception('[Service process error] ' . $e->getMessage());
        }
    }

    public function getConsumer()
    {
        if ( null == $this->consumer ) {
            $this->consumer = new Consumer($this->params);
        }
        return $this->consumer;
    }

    public function setConsumer(Consumer $consumer)
    {
        $this->consumer = $consumer;
    }

    public function getStorage()
    {
        if ( null == $this->storage ) {
            $this->storage = new Storage(new MongoDB);
        }
        return $this->storage;
    }

    public function setStorage(Storage $storage)
    {
        $this->storage = $storage;
    }
}