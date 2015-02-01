<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 22/01/15
 * Time: 00:11
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Query;


use Virhi\Component\Exception\InvalidContextException;
use Virhi\Component\Query\Context\ContextInterface;
use Virhi\Component\Query\QueryInterface;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Query\MockContext;
use Virhi\LazyMockApiBundle\Mock\Application\Factory\ReadRequestFactory;


class MockQuery extends AbstractQuery implements QueryInterface
{
    /**
     * @param ContextInterface $context
     * @return \Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock
     */
    public function execute(ContextInterface $context)
    {
        if (!$context instanceof MockContext) {
            throw new InvalidContextException();
        }

        $request = ReadRequestFactory::build($context->getRequest());
        return $this->getReadService()->getMock($request);
    }
} 