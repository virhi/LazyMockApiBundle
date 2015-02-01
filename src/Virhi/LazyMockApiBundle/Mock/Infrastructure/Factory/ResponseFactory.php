<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 13:39
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory;


use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Response;

class ResponseFactory
{
    /**
     * @param Request $request
     * @return Mock
     */
    public static function build($jsonResponse)
    {
        $content = json_decode($jsonResponse);
        $mapping = array(
            'status'  => 'setStatus',
            'content' => 'setContent',
        );

        if (!is_object($content) || !property_exists($content, 'response')) {
            throw new \RuntimeException('error de response builder');
        }

        $result = new Response();
        $request = $content->response;
        foreach ($mapping as $attribut => $method) {
            if (!property_exists($request, $attribut)) {
                throw new \RuntimeException('error de response builder');
            }
            $result->{$method}($request->{$attribut});
        }

        return $result;
    }
}