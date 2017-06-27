<?php

/**
 * Copyright 2014 Fabian Grutschus. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * The views and conclusions contained in the software and documentation are those
 * of the authors and should not be interpreted as representing official policies,
 * either expressed or implied, of the copyright holders.
 *
 * @author    Fabian Grutschus <f.grutschus@lubyte.de>
 * @copyright 2014 Fabian Grutschus. All rights reserved.
 * @license   BSD
 * @link      http://github.com/fabiang/xmpp
 */

namespace Fabiang\Xmpp\EventListener\Stream;

use Fabiang\Xmpp\Event\XMLEvent;
use Fabiang\Xmpp\EventListener\AbstractEventListener;
use Fabiang\Xmpp\EventListener\BlockingEventListenerInterface;
use Fabiang\Xmpp\EventListener\UnBlockingEventListenerInterface;
use Fabiang\Xmpp\Protocol\Room\Room;
use Fabiang\Xmpp\Protocol\User\User;

/**
 * Listener
 *
 * @see https://xmpp.org/extensions/xep-0045.html#createroom-general
 *
 * @package Xmpp\EventListener
 */
class RoomPresence extends AbstractEventListener implements BlockingEventListenerInterface, UnBlockingEventListenerInterface
{

    /**
     * Blocking.
     *
     * @var boolean
     */
    protected $blocking = false;

    /**
     * user object.
     *
     * @var User
     */
    protected $userObject;

    /**
     * {@inheritDoc}
     */
    public function attachEvents()
    {
        $this->getOutputEventManager()
            ->attach('{http://jabber.org/protocol/muc}x', array($this, 'query'));

        $this->getInputEventManager()
            ->attach('{http://jabber.org/protocol/muc#user}x', array($this, 'result'));
    }

    /**
     * Sending a query request for roster sets listener to blocking mode.
     *
     * @return void
     */
    public function query()
    {
        $this->blocking = true;
    }

    /**
     * Result received.
     *
     * @param \Fabiang\Xmpp\Event\XMLEvent $event
     * @return void
     */
    public function result(XMLEvent $event)
    {
        if ($event->isEndTag()) {
            if (!$room = $this->getOptions()->getRoom()) {
                $room = new Room();
                $this->getOptions()->setRoom($room);
            }

            /** @var \DOMElement $element */
            $element = $event->getParameter(0);
            $from = $element->parentNode->getAttribute('from');
            $from = explode("/", $from);
            $room->setJid($from[0]);

            $affiliationNode = $element->getElementsByTagName('item')->item(0);
            if ($affiliationNode && $affiliation = $affiliationNode->getAttribute('affiliation')) {
                $room->setAffiliation($affiliation);
            } else {
                $room->setAffiliation(Room::AFFILIATION_OUTCAST);
            }

            $statusNodeList = $element->getElementsByTagName('status');
            if ($statusNodeList->length > 0) {
                for ($i = 0; $i < $statusNodeList->length; $i++) {
                    $statusNode = $statusNodeList->item($i);
                    $room->addStatus($statusNode->getAttribute('code'));
                }
            }
            $this->blocking = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isBlocking()
    {
        return $this->blocking;
    }

    /**
     * {@inheritDoc}
     */
    public function unBlock()
    {
        $this->blocking = false;
    }
}