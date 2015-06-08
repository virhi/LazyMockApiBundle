<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/04/15
 * Time: 21:10
 */

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory\ResponseFactory;

class ResponseFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildWillThrowRuntimeException()
    {
        $this->setExpectedException('\RuntimeException','error de response builder');
        ResponseFactory::build('toto');
    }

    public function testBuildWillTCreateResponse()
    {
        $request = array(
            'response' => array(
                'status'  => 'toto',
                'content' => 'content',
            )
        );

        $actual = ResponseFactory::build(json_encode($request));
        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Response', $actual);
        $this->assertEquals('toto', $actual->getStatus());
        $this->assertEquals('content', $actual->getContent());
    }

    public function testBuildWillTCreateResponseWhitDate()
    {
        $request = array(
            'response' => array(
                'status'  => 'toto',
                'content' => array('date' => '1 days'),
            )
        );

        $actual = ResponseFactory::build(json_encode($request));
        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Response', $actual);
        $this->assertEquals('toto', $actual->getStatus());
        $this->assertTrue(property_exists($actual->getContent(), 'date'));

        $this->assertInstanceOf('\DateTime', $actual->getContent()->date);
        $this->assertEquals((new \DateTime())->add(\DateInterval::createFromDateString('1 day'))->format('d/m/Y'), $actual->getContent()->date->format('d/m/Y'));

    }
}