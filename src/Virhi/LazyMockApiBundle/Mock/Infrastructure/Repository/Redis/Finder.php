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
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory\MockFactory;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Search\Search;

class Finder extends Repository implements FinderInterface
{
    /**
     * @param SearchInterface $search
     * @return mixed
     */
    public function find(SearchInterface $search)
    {
        $result = null;
        if (!$search instanceof Search) {
            throw new \RuntimeException("invalid search");
        }

        $key        = md5(json_encode($search->getRequest()));
        $jsonResult = $this->getClient()->get($key);

        if ($jsonResult != null ) {
            $result = MockFactory::build($this->getClient()->get($key));
        }
        return $result;
    }

} 