<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 22:34
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis;

use Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory\MockFactory;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class MockRepository extends Repository
{
    /**
     * @param $key
     * @return Mock
     */
    public function getMock($key)
    {
        return MockFactory::build($this->getByKey($key));
    }
}