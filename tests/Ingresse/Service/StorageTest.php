<?php

class StorageTest extends PHPUnit_Framework_TestCase
{

    public function getEvents()
    {
        return [
            [
                ['name'  => 'Rolezinho 001'],
                ['date'  => '2014-05-10'],
                ['where' => 'Vale do Anhangabau'],
                ['city'  => 'São Paulo'],
            ],
            [
                ['name'  => 'Rolezinho 002'],
                ['date'  => '2014-05-10'],
                ['where' => 'Parque do Ibirapuera'],
                ['city'  => 'São Paulo'],
            ],
        ];
    }

    /**
     * @dataProvider getEvents
     * @covers Ingresse\Service\Storage::getEvents
     * @covers Ingresse\Service\Storage::saveEvents
     */
    public function testSaveEventsOnEmptyCollection()
    {
        $fbId    = 'fb001';
        $events  = $this->getEvents();
        $mongo   = new MongoClient;
        $dbTest  = $mongo->fbTest;
        $storage = new Ingresse\Service\Storage($dbTest);

        $storage->saveEvents($events, $fbId);

        $cursor  = $storage->getEvents($fbId);

        $this->assertEquals(count($events), $cursor->count());
    }

    /**
     * @dataProvider getEvents
     */
    public function testSaveEventsOnCollectionAlreadyWithData()
    {
        $fbId    = 'fb001';
        $events  = $this->getEvents();
        $mongo   = new MongoClient;
        $dbTest  = $mongo->fbTest;
        $dbTest->$fbId->batchInsert($events);
        $storage = new Ingresse\Service\Storage($dbTest);

        $storage->saveEvents($events, $fbId);

        $cursor  = $storage->getEvents($fbId);

        $this->assertEquals(count($events), $cursor->count());
    }
}
