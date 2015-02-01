<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 22/01/15
 * Time: 00:02
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis;

use Virhi\Component\Repository\ListFinderInterface;
use Virhi\Component\Search\SearchInterface;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory\MockFactory;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Search\ListSearch;

class ListFinder extends Repository implements ListFinderInterface
{
    /**
     * @param SearchInterface $search
     * @return mixed
     */
    public function find(SearchInterface $search)
    {
        if (!$search instanceof ListSearch) {
            throw new \RuntimeException('invalid search');
        }

        $keys   = $this->getClient()->keys('*');
        $result = array();

        foreach ($keys as $key) {
            try {
                $result[] = MockFactory::build($this->getClient()->get($key));
            } catch (\Exception $e) {

            }
        }

        return $result;
    }


} 