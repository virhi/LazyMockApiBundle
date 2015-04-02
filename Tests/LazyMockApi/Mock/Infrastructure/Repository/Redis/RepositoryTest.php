<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/04/15
 * Time: 19:29
 */

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\Repository;
class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    function testGetByKeyWillThrowException()
    {
        $this->setExpectedException('\RuntimeException', 'mock for toto do not exist');

        $client = $this->getMockBuilder('\Predis\Client')
                ->disableOriginalConstructor()
                ->setMethods(array('exists'))
                ->getMock();

        $client->expects($this->once())
            ->method('exists')
            ->will($this->returnValue(false));

        $repo = new Repository($client);
        $repo->getByKey('toto');
    }

    function testGetByKey()
    {
        $expected = 'toto';
        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('exists', 'get'))
            ->getMock();

        $client->expects($this->once())
            ->method('exists')
            ->will($this->returnValue(true));

        $client->expects($this->once())
            ->method('get')
            ->will($this->returnValue($expected));

        $repo = new Repository($client);
        $actual = $repo->getByKey('toto');

        $this->assertEquals($expected, $actual);
    }

    function testDeleteAll()
    {
        $expected = 'toto';
        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('keys', 'del'))
            ->getMock();

        $client->expects($this->once())
            ->method('keys')
            ->will($this->returnValue('dummy'));

        $client->expects($this->once())
            ->method('del')
            ->will($this->returnValue($expected));

        $repo = new Repository($client);
        $repo->deleteAll();
    }

    function testDeleteList()
    {
        $expected = 'toto';
        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('del'))
            ->getMock();

        $client->expects($this->exactly(2))
            ->method('del')
            ->will($this->returnValue($expected));

        $repo = new Repository($client);
        $repo->deleteList(array(1,2));
    }
}