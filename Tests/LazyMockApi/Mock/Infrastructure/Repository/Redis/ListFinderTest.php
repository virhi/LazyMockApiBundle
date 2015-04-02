<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/04/15
 * Time: 20:21
 */

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\ListFinder;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;


class ListFinderTest extends \PHPUnit_Framework_TestCase
{
    function testGetMockWillThrowException()
    {
        $this->setExpectedException('\RuntimeException','invalid search');

        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('get', 'exists'))
            ->getMock();


        $search = $this->getMock('\Virhi\Component\Search\SearchInterface');

        $repo   = new ListFinder($client);
        $actual = $repo->find($search);

        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock', $actual);
    }

    function testGetMock()
    {
        $client = $this->getMockBuilder('\Predis\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('keys', 'get', 'exists'))
            ->getMock();

        $mock = new Mock();

        $client->expects($this->once())
            ->method('keys')
            ->will($this->returnValue(array(json_encode($mock))));

        $client->expects($this->once())
            ->method('exists')
            ->will($this->returnValue(true));

        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue(json_encode($mock)));


        $search = $this->getMockBuilder('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Search\ListSearch')
            ->disableOriginalConstructor()
            ->setMethods(array('getRequest'))
            ->getMock();

        $search->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue(null));

        $repo   = new ListFinder($client);
        $actual = $repo->find($search);

        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock', $actual[0]);
    }
}