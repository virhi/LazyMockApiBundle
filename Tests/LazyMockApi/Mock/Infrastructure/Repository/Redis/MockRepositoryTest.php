<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/04/15
 * Time: 19:58
 */

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\MockRepository;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class MockRepositoryTest extends \PHPUnit_Framework_TestCase
{
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

        $repo = new MockRepository($client);
        $actual = $repo->getMock('toto');

        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock', $actual);
    }
}