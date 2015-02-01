<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 22/01/15
 * Time: 00:03
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis;


use Virhi\Component\Repository\AttacherInterface;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class Attacher extends Repository implements AttacherInterface
{
    public function attach($mock)
    {
        if (!$mock instanceof Mock) {
            throw new \RuntimeException("Invalid entity to save");
        }
        $this->getClient()->set($mock->getId(), json_encode($mock->jsonSerialize()));
    }
}