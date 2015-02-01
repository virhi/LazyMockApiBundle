<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 25/01/15
 * Time: 14:56
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Search;

use Virhi\Component\Search\Search as BaseSearch;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Request;

class Search extends BaseSearch
{
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}