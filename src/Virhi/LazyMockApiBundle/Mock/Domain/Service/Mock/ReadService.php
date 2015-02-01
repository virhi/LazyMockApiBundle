<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 31/01/15
 * Time: 10:05
 */

namespace Virhi\LazyMockApiBundle\Mock\Domain\Service\Mock;

use Virhi\Component\Repository\FinderInterface;
use Virhi\Component\Repository\ListFinderInterface;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Request;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Search\Search;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Search\ListSearch;

class ReadService 
{
    /**
     * @var FinderInterface
     */
    protected $finder;

    /**
     * @var ListFinderInterface
     */
    protected $listFinder;

    function __construct(FinderInterface $finder, ListFinderInterface $listFinder)
    {
        $this->finder = $finder;
        $this->listFinder = $listFinder;
    }

    /**
     * @param Request $request
     * @return Mock
     */
    public function getMock(Request $request)
    {
        $search = new Search($request);
        $mock   = $this->finder->find($search);

        if ($mock === null || !$mock instanceof Mock) {
            throw new \RuntimeException("le mock n'as pas été trouvé");
        }

        return $mock;
    }

    public function getListMock()
    {
        $search = new ListSearch();
        return $this->listFinder->find($search);
    }

}