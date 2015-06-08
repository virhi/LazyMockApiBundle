<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 13:39
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory;


use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Response;
use Virhi\Component\Date\Interval\DateIntervalService;

class ResponseFactory
{
    use DateIntervalService;

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

        return self::buildContent($result);
    }

    protected static function buildContent(Response $response)
    {
        if (is_object($response->getContent())) {
            $properties = get_object_vars($response->getContent());
            foreach ($properties as $propertieName => $propertieValue) {
                $dateInterval = \DateInterval::createFromDateString($propertieValue);
                if (!self::dateIntervalisNull($dateInterval)) {
                    $date = new \DateTime();
                    $date->add($dateInterval);
                    $response->getContent()->{$propertieName} = $date;
                }
            }
        }

        return $response;
    }
}