<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 25/01/15
 * Time: 22:25
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity;

class Entity implements \JsonSerializable
{
    function jsonSerialize()
    {
        return get_object_vars($this);
    }

}