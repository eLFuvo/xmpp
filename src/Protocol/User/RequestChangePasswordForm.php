<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 07.03.17
 * Time: 18:42
 */

namespace Fabiang\Xmpp\Protocol\User;


use Fabiang\Xmpp\Protocol\ProtocolImplementationInterface;
use Fabiang\Xmpp\Util\XML;

/**
 * Class RequestChangePasswordForm
 *
 * Before change user password you should request form that
 *
 * @see https://xmpp.org/extensions/xep-0133.html#change-user-password
 * @package Fabiang\Xmpp\Protocol\User
 */
class RequestChangePasswordForm implements ProtocolImplementationInterface
{

    /**
     * admin user JID
     *
     * @var string
     */
    protected $from;
    /**
     * Set receiver.
     *
     * @var string
     */
    protected $to;

    /**
     * RequestChangePasswordForm constructor.
     * @param $from
     * @param null|string $to
     */
    public function __construct($from, $to = null)
    {
        $this->setFrom($from)
            ->setTo($to);
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return XML::quoteMessage(
            "<iq from='%s' id='%s' to='%s' type='set' xml:lang='en'>" .
            "<command xmlns='http://jabber.org/protocol/commands' " .
            "action='execute' " .
            "node='http://jabber.org/protocol/admin#change-user-password'/>" .
            "</iq>",
            $this->getFrom(),
            XML::generateId(),
            $this->getTo()
        );
    }

    /**
     * Get server address.
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set receiver - for example: xmpp.example.org
     *
     * @param $to string
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = (string)$to;
        return $this;
    }

    /**
     * Get JabberID.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set jabberID.
     *
     * @param $from string
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = (string)$from;
        return $this;
    }
}