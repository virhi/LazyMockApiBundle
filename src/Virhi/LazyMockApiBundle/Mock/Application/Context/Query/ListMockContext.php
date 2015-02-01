<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 31/01/15
 * Time: 09:57
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Context\Query;

use Virhi\Component\Query\Context\ContextInterface;

class ListMockContext implements ContextInterface
{
    protected $limit;

    function __construct($limit = '0:5')
    {
        $this->limit = $limit;
    }
}