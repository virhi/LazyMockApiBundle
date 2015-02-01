<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 13:42
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory;


use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class MockFactory
{
    /**
     * @param Request $request
     * @return Mock
     */
    public static function build($json)
    {
        $resquest = RequestFactory::build($json);
        $response = ResponseFactory::build($json);
        $mock     = new Mock($resquest, $response);

        return $mock;
    }
}