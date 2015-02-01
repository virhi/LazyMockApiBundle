<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 10:37
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis;

use Virhi\Component\Repository\RemoverInterface;

class Remover extends Repository implements RemoverInterface
{
    public function remove($entity)
    {
        $this->getClient()->set('toto', 'tata');
    }
}