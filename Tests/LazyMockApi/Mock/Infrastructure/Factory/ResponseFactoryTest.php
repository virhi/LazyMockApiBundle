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
                'content' => json_encode(array('date' => '1 days')),
            )
        );

        $actual = ResponseFactory::build(json_encode($request));
        $content = json_decode($actual->getContent());

        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Response', $actual);
        $this->assertEquals('toto', $actual->getStatus());
        $this->assertTrue(property_exists($content, 'date'));
        $this->assertEquals((new \DateTime())->add(\DateInterval::createFromDateString('1 day'))->format('Y-m-d h:i:s.u'), $content->date->date);

    }
}