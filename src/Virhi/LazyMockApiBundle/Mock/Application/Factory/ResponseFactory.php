<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 11:09
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Factory;

use Symfony\Component\HttpFoundation\Request;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Response;

class ResponseFactory 
{
    /**
     * @param Request $request
     * @return Mock
     */
    public static function build(Request $requestHttpFoundation)
    {
        $content = json_decode($requestHttpFoundation->getContent());
        $mapping = array(
            'status'     => 'setStatus',
            'content' => 'setContent',
        );

        if (!property_exists($content, 'response')) {
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