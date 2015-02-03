<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 22/01/15
 * Time: 00:02
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis;

use Virhi\Component\Repository\FinderInterface;
use Virhi\Component\Search\SearchInterface;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Search\Search;

class Finder extends MockRepository implements FinderInterface
{
    /**
     * @param SearchInterface $search
     * @return \Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock
     */
    public function find(SearchInterface $search)
    {
        if (!$search instanceof Search) {
            throw new \RuntimeException("invalid search");
        }

        $key = md5(json_encode($search->getRequest()));
        return $this->getMock($key);
    }

} 