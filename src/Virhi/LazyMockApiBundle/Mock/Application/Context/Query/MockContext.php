<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 31/01/15
 * Time: 09:58
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Context\Query;

use Virhi\Component\Query\Context\ContextInterface;

class MockContext implements ContextInterface
{

    protected $key;

    function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }


}