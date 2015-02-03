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

    /**
     * @param $key
     * @return mixed
     */
    public function getByKey($key)
    {
        if (!$this->getClient()->exists($key)) {
            throw new \RuntimeException('mock for ' . $key . ' do not exist');
        }
        return $this->getClient()->get($key);
    }

    public function deleteAll()
    {
        $this->delete($this->getClient()->keys('*'));
    }

    public function deleteList(array $keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    public function delete($key)
    {
        $this->getClient()->del($key);
    }

}