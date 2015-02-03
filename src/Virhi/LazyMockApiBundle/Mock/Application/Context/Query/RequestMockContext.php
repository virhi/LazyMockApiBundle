<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 03/02/15
 * Time: 22:16
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Context\Query;

use Virhi\Component\Query\Context\ContextInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestMockContext implements ContextInterface
{
    /**
     * @var Request
     */
    protected $request;

    function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

}