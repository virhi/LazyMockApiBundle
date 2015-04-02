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
                'status'     => 'toto',
                'content' => 'content',
            )
        );

        $actual = ResponseFactory::build(json_encode($request));
        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Response', $actual);
        $this->assertEquals('toto', $actual->getStatus());
        $this->assertEquals('content', $actual->getContent());
    }
}