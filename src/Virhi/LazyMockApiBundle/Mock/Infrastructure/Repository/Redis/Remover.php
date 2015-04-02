<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 10:37
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis;

use Virhi\Component\Repository\RemoverInterface;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class Remover extends Repository implements RemoverInterface
{
    public function remove($mock)
    {
        if (!$mock instanceof Mock) {
            throw new \RuntimeException("Invalid entity to remove");
        }
        $this->getClient()->del($mock->getId());
    }
}