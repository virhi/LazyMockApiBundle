<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 22/01/15
 * Time: 00:12
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Query;

use Virhi\Component\Query\Context\ContextInterface;
use Virhi\Component\Query\QueryInterface;

class ListMockQuery extends AbstractQuery implements QueryInterface
{

    public function execute(ContextInterface $context)
    {
        return $this->getReadService()->getListMock();
    }

} 