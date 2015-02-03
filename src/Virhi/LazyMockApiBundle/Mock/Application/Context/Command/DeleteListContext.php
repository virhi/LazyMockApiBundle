<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 23:19
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Context\Command;

use Virhi\Component\Command\Context\ContextInterface;

class DeleteListContext implements ContextInterface
{
    /**
     * @var array
     */
    protected $keys;

    /**
     * @var bool
     */
    protected $all;

    function __construct($all = false, array $keys = array())
    {
        $this->keys = $keys;
        $this->all  = $all;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @return boolean
     */
    public function isAll()
    {
        return $this->all;
    }

}