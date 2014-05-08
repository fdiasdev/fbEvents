<?php

class FacebookTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Ingresse\Service\Facebook::searchAndSaveEvents
     */
    public function testSearchAndSaveEvents()
    {
        $session = new Facebook\FacebookSession('abc-123-456');

        $params = ['app_id' => '001', 'app_key' => 'x01', 'callback' => 'url.dev'];

        $consumer = $this->getMock(
            'Ingresse\Consumer\Facebook',
            ['getEvents', 'getProfile'],
            [ $params ]
        );

        $eventsData = [ 'data' =>
            [ 'name' => 'event 001' ],
        ];

        $consumer->expects($this->once())
                 ->method('getEvents')
                 ->with($session)
                 ->will($this->returnValue($eventsData));

        $consumer->expects($this->once())
                 ->method('getProfile')
                 ->with($session)
                 ->will($this->returnValue([
                        'id' => 'A001',
                        'name' => 'username'
                    ]));

        $storage = $this->getMockBuilder('Ingresse\Service\Storage')
                     ->disableOriginalConstructor()
                     ->getMock();

        $storage->expects($this->once())
                 ->method('saveEvents')
                 ->with($eventsData['data'], 'uA001')
                 ->will($this->returnValue(true));

        $service = new Ingresse\Service\Facebook([]);
        $service->setSession($session);
        $service->setConsumer($consumer);
        $service->setStorage($storage);

        $service->searchAndSaveEvents();
    }
}