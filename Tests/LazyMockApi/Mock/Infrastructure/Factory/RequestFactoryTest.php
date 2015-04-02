<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/04/15
 * Time: 20:58
 */

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory\RequestFactory;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildWillThrowRuntimeException()
    {
        $this->setExpectedException('\RuntimeException','error de request builder');
        RequestFactory::build('toto');
    }

    public function testBuildWillTCreateRequest()
    {
        $request = array(
            'request' => array(
                'url'     => 'toto',
                'method'  => 'tata',
                'content' => 'content',
            )
        );
        $actual = RequestFactory::build(json_encode($request));

        $this->assertInstanceOf('\Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Request', $actual);
        $this->assertEquals('toto', $actual->getUrl());
        $this->assertEquals('tata', $actual->getMethod());
        $this->assertEquals('content', $actual->getContent());
    }
}