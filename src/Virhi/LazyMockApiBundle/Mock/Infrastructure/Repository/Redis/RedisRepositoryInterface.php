<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/04/15
 * Time: 19:25
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis;

use Predis\ClientInterface;

interface RedisRepositoryInterface
{
    /**
     * @return ClientInterface
     */
    public function getClient();
}