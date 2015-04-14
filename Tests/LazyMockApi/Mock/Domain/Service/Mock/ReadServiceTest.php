<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 05/04/15
 * Time: 11:23
 */

use Virhi\LazyMockApiBundle\Mock\Domain\Service\Mock\ReadService;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Request;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class ReadServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMockWIllThrowRuntimeException()
    {
        $this->setExpectedException('\RuntimeException',"le mock n'as pas été trouvé.");

        $finder = $this->getMockBuilder('\Virhi\Component\Repository\FinderInterface')
            ->setMethods(array('find'))
            ->getMock();

        $finder->expects($this->once())
            ->method('find')
            ->will($this->returnValue(null));

        $listFinder = $this->getMockBuilder('\Virhi\Component\Repository\ListFinderInterface')
            ->setMethods(array('find'))
            ->getMock();

        $mockRepository = $this->getMockBuilder('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\MockRepository')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        $service = new ReadService($finder, $listFinder, $mockRepository);
        $service->getMock(new Request());
    }

    public function testGetMock()
    {
        $finder = $this->getMockBuilder('\Virhi\Component\Repository\FinderInterface')
            ->setMethods(array('find'))
            ->getMock();

        $finder->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new Mock()));

        $listFinder = $this->getMockBuilder('\Virhi\Component\Repository\ListFinderInterface')
            ->setMethods(array('find'))
            ->getMock();

        $mockRepository = $this->getMockBuilder('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\MockRepository')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        $service = new ReadService($finder, $listFinder, $mockRepository);
        $actual  = $service->getMock(new Request());

        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock', $actual);
    }

    public function testGetListMock()
    {
        $finder = $this->getMockBuilder('\Virhi\Component\Repository\FinderInterface')
            ->setMethods(array('find'))
            ->getMock();

        $listFinder = $this->getMockBuilder('\Virhi\Component\Repository\ListFinderInterface')
            ->setMethods(array('find'))
            ->getMock();

        $listFinder->expects($this->once())
            ->method('find')
            ->will($this->returnValue(array()));

        $mockRepository = $this->getMockBuilder('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\MockRepository')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        $service = new ReadService($finder, $listFinder, $mockRepository);
        $actual  = $service->getListMock();
    }

    public function testGetMockByKey()
    {
        $finder = $this->getMockBuilder('\Virhi\Component\Repository\FinderInterface')
            ->setMethods(array('find'))
            ->getMock();

        $listFinder = $this->getMockBuilder('\Virhi\Component\Repository\ListFinderInterface')
            ->setMethods(array('find'))
            ->getMock();

        $mockRepository = $this->getMockBuilder('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\MockRepository')
            ->disableOriginalConstructor()
            ->setMethods(array('getMock'))
            ->getMock();

        $mockRepository->expects($this->once())
            ->method('getMock')
            ->will($this->returnValue(new Mock()));

        $service = new ReadService($finder, $listFinder, $mockRepository);
        $actual  = $service->getMockByKey('toto');
        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock', $actual);
    }
}