<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 05/04/15
 * Time: 14:07
 */

use \Virhi\LazyMockApiBundle\Mock\Domain\Service\Mock\WriteService;
use \Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class WriteServicetest extends \PHPUnit_Framework_TestCase
{
    public function testEditMock()
    {
        $attacher = $this->getMockBuilder('\Virhi\Component\Repository\AttacherInterface')
            ->setMethods(array('attach'))
            ->getMock();

        $attacher->expects($this->once())
            ->method('attach')
            ->will($this->returnValue(null));

        $remover = $this->getMockBuilder('\Virhi\Component\Repository\RemoverInterface')
            ->setMethods(array('remove'))
            ->getMock();

        $remover->expects($this->never())
            ->method('remove')
            ->will($this->returnValue(null));

        $service = new WriteService($attacher, $remover);
        $service->editMock(new Mock());
    }

    public function testRemoveMock()
    {
        $attacher = $this->getMockBuilder('\Virhi\Component\Repository\AttacherInterface')
            ->setMethods(array('attach'))
            ->getMock();

        $attacher->expects($this->never())
            ->method('attach')
            ->will($this->returnValue(null));

        $remover = $this->getMockBuilder('\Virhi\Component\Repository\RemoverInterface')
            ->setMethods(array('remove'))
            ->getMock();

        $remover->expects($this->once())
            ->method('remove')
            ->will($this->returnValue(null));

        $service = new WriteService($attacher, $remover);
        $service->removeMock(new Mock());
    }
}