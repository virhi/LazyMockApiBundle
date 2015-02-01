<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 31/01/15
 * Time: 09:50
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Context\Command;


use Virhi\Component\Command\Context\ContextInterface;
use Symfony\Component\HttpFoundation\Request;

class MockContext implements ContextInterface
{
    /**
     * @var Request
     */
    protected $request;

    function __construct(Request $request)
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