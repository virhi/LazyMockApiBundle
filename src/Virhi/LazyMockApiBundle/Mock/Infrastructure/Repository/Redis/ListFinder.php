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

class ListFinder extends Repository implements ListFinderInterface
{
    /**
     * @param SearchInterface $search
     * @return mixed
     */
    public function find(SearchInterface $search)
    {
        return $this->getClient()->keys('*');
    }


} 