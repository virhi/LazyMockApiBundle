<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 25/01/15
 * Time: 22:46
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Factory;

use Symfony\Component\HttpFoundation\Request;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class MockFactory
{
    /**
     * @param Request $request
     * @return Mock
     */
    public static function build(Request $requestHttpFoundation)
    {
        $resquest = RequestFactory::build($requestHttpFoundation);
        $response = ResponseFactory::build($requestHttpFoundation);
        $mock     = new Mock($resquest, $response);

        return $mock;
    }
}