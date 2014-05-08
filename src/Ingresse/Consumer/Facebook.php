<?php

namespace Ingresse\Consumer;

use Ingresse\Consumer\ConsumerInterface;
use Facebook\FacebookRedirectLoginHelper as FacebookHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\FacebookRequestException;

class Facebook implements ConsumerInterface
{

    const PERMISSION_EVENT = 'user_events';

    /**
     * @var string
     */
    private $callback;

    /**
     * @var Facebook\FacebookRedirectLoginHelper
     */
    private $helper;


    public function __construct($params)
    {
        if ( !array_key_exists('app_id', $params)
            || !array_key_exists('app_key', $params)
            || !array_key_exists('callback', $params)
        ) {
            throw new InvalidArgumentException('Mandatory Parameters must be informed');
        }

        FacebookSession::setDefaultApplication(
            $params['app_id'], $params['app_key']
        );

        $this->callback = $params['callback'];
    }

    public function getUrl()
    {
        return $this->getHelper()->getLoginUrl([self::PERMISSION_EVENT]);
    }

    public function requestSession()
    {
        try {
            return $this->getHelper()->getSessionFromRedirect();
        } catch(FacebookRequestException $e) {
            // @todo implements log
        } catch(\Exception $e) {
            // @todo implements log
        }
        return null;
    }

    public function getEvents(FacebookSession $session)
    {
        $request = $this->getRequest($session, 'events');
        return $request->execute()->getGraphObject()->asArray();
    }

    public function getProfile(FacebookSession $session)
    {
        $request = $this->getRequest($session);
        return $request->execute()->getGraphObject()->asArray();
    }

    public function getHelper()
    {
        if ( null == $this->helper ) {
            $this->helper = new FacebookHelper($this->callback);
        }
        return $this->helper;
    }

    public function setHelper(FacebookHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getRequest($session, $request = '')
    {
        return new FacebookRequest($session, 'GET', '/me/' . $request);
    }

}