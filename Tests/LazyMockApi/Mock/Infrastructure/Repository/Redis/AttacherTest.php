<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/04/15
 * Time: 19:50
 */

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\Attacher;

class AttacherTest extends \PHPUnit_Framework_TestCase
{
    public function testAttachWillThrowException()
    {
        $this->setExpectedException('\RuntimeException', "Invalid entity to save");

        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('del'))
            ->getMock();


        $attacher = new Attacher($client);
        $attacher->attach('dummy');
    }

    public function testAttach()
    {
        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('set'))
            ->getMock();

        $client->expects($this->once())
            ->method('set')
            ->will($this->returnValue(null));


        $mock = $this->getMockBuilder('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock')
            ->disableOriginalConstructor()
            ->setMethods(array('getId', 'jsonSerialize'))
            ->getMock();

        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(null));

        $mock->expects($this->once())
            ->method('jsonSerialize')
            ->will($this->returnValue(null));

        $attacher = new Attacher($client);
        $attacher->attach($mock);
    }
}