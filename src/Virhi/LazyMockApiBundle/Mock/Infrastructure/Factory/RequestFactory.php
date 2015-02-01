<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 13:37
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory;

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Request;

class RequestFactory
{
    static public function build($jsonRequest)
    {
        $content = json_decode($jsonRequest);
        $mapping = array(
            'url'     => 'setUrl',
            'method'  => 'setMethod',
            'content' => 'setContent',
        );

        if (!is_object($content) || !property_exists($content, 'request')) {
            throw new \RuntimeException('error de request builder');
        }

        $result = new Request();
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