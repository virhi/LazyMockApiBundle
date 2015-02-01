<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 12:23
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Factory;

use Symfony\Component\HttpFoundation\Request;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Request as MockRequest;

class ReadRequestFactory 
{
    /**
     * @param Request $request
     * @return MockRequest
     */
    public static function build(Request $requestHttpFoundation)
    {
        $result  = new MockRequest();
        $result->setUrl($requestHttpFoundation->attributes->get('url'));
        $result->setMethod($requestHttpFoundation->getMethod());
        $result->setContent($requestHttpFoundation->getContent());

        return $result;
    }
}