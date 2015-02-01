<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 11:09
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Factory;

use Symfony\Component\HttpFoundation\Request;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Request as MockRequest;

class RequestFactory 
{
    /**
     * @param Request $request
     * @return MockRequest
     */
    public static function build(Request $requestHttpFoundation)
    {
        $content = json_decode($requestHttpFoundation->getContent());
        $mapping = array(
            'url'     => 'setUrl',
            'method'  => 'setMethod',
            'content' => 'setContent',
        );

        if (!property_exists($content, 'request')) {
            throw new \RuntimeException('error de request builder');
        }

        $result = new MockRequest();
        $request = $content->request;
        foreach ($mapping as $attribut => $method) {
            if (!property_exists($request, $attribut)) {
                throw new \RuntimeException('error de request builder');
            }
            $result->{$method}($request->{$attribut});
        }

        return $result;
    }
}