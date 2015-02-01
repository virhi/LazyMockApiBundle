<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 24/01/15
 * Time: 14:01
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis;

use Predis\Client;

class Repository
{
    /**
     * @var Client
     */
    protected $client;

    function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

}