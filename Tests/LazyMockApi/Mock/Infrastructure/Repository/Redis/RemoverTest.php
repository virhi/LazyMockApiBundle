<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/04/15
 * Time: 20:06
 */

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\Remover;

class RemoverTest extends \PHPUnit_Framework_TestCase
{
    public function testAttachWillThrowException()
    {
        $this->setExpectedException('\RuntimeException', "Invalid entity to remove");

        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('del'))
            ->getMock();


        $remover = new Remover($client);
        $remover->remove('dummy');
    }

    public function testAttach()
    {
        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('del'))
            ->getMock();

        $client->expects($this->once())
            ->method('del')
            ->will($this->returnValue(null));


        $mock = $this->getMockBuilder('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock')
            ->disableOriginalConstructor()
            ->setMethods(array('getId'))
            ->getMock();

        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(null));

        $remover = new Remover($client);
        $remover->remove($mock);
    }
}