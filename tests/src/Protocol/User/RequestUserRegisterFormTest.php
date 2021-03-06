<?php
namespace Fabiang\Xmpp\Protocol\User;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-08 at 20:26:46.
 */
class RequestUserRegisterFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestUserRegisterForm
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new RequestUserRegisterForm('admin@xmpp.server.org', 'xmpp.server.org');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * Test turning object into string.
     *
     * @covers ::toString
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::__construct
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::getType
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::setType
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::getTo
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::setTo
     * @uses Fabiang\Xmpp\Util\XML::generateId
     * @uses Fabiang\Xmpp\Util\XML::quote
     * @uses Fabiang\Xmpp\Util\XML::quoteMessage
     * @return void
     */
    public function testToString()
    {
        $this->object->setTo('xmpp.server.org')->setFrom('admin@xmpp.server.org');
        $this->assertRegExp(
            "#<iq from='admin@xmpp.server.org' id='fabiang_xmpp_[^\']+' to='xmpp.server.org' type='set' xml:lang='en'>" .
            "<command xmlns='http://jabber.org/protocol/commands' action='execute' node='http://jabber.org/protocol/admin\#add-user'/>" .
            "</iq>#",
            $this->object->toString()
        );
    }

    /**
     * Test constructor.
     *
     * @covers ::__construct
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::getFrom
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::setFrom
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::getTo
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::setTo
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::getMessage
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::setMessage
     * @return void
     */
    public function testConstructor()
    {
        $object = new RequestUserRegisterForm('admin@xmpp.server.org', 'xmpp.server.org');
        $this->assertSame('admin@xmpp.server.org', $object->getFrom());
        $this->assertSame('xmpp.server.org', $object->getTo());
    }

    /**
     * Test setters and getters.
     *
     * @covers ::getFrom
     * @covers ::setFrom
     * @covers ::getTo
     * @covers ::setTo
     * @uses Fabiang\Xmpp\Protocol\User\RequestUserRegisterForm::__construct
     * @return void
     */
    public function testSettersAndGetters()
    {
        $this->assertSame('admin@xmpp.server.org', $this->object->getFrom());
        $this->assertSame('user@xmpp.server.org', $this->object->setFrom('user@xmpp.server.org')->getFrom());
        $this->assertSame('xmpp.server.org', $this->object->getTo());
        $this->assertSame('xmpp.other.server.org', $this->object->setTo('xmpp.other.server.org')->getTo());
    }
}
