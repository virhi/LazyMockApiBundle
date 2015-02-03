<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 23:17
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Command;

use Virhi\Component\Command\CommandInterface;
use Virhi\Component\Command\Context\ContextInterface;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Command\DeleteListContext;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Repository\Redis\MockRepository;

class DeleteListCommand implements CommandInterface
{
    /**
     * @var MockRepository
     */
    protected $repository;

    function __construct(MockRepository $repository)
    {
        $this->repository = $repository;
    }


    public function execute(ContextInterface $context)
    {
        if (!$context instanceof DeleteListContext) {
            throw new InvalidContextException();
        }

        if ($context->isAll()) {
            $this->repository->deleteAll();
        } else {
            $this->repository->deleteList($context->getKeys());
        }
    }
}