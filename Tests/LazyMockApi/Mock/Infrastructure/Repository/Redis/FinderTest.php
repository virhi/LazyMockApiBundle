<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/04/15
 * Time: 20:11
 */

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\Finder;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;


class FinderTest extends \PHPUnit_Framework_TestCase
{
    function testGetMockWillThrowException()
    {
        $this->setExpectedException('\RuntimeException','invalid search');

        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('get', 'exists'))
            ->getMock();


        $search = $this->getMock('\Virhi\Component\Search\SearchInterface');

        $repo   = new Finder($client);
        $actual = $repo->find($search);

        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock', $actual);
    }

    function testGetMock()
    {
        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('get', 'exists'))
            ->getMock();

        $mock = new Mock();

        $client->expects($this->once())
            ->method('exists')
            ->will($this->returnValue(true));

        $client->expects($this->once())
            ->method('get')
            ->will($this->returnValue(json_encode($mock)));


        $search = $this->getMockBuilder('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Search\Search')
            ->disableOriginalConstructor()
            ->setMethods(array('getRequest'))
            ->getMock();

        $search->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue(null));

        $repo   = new Finder($client);
        $actual = $repo->find($search);

        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock', $actual);
    }
}