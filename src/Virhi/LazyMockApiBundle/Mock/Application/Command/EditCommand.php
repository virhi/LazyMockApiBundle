<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 31/01/15
 * Time: 09:46
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Command;


use Virhi\Component\Command\CommandInterface;
use Virhi\Component\Command\Context\ContextInterface;
use Virhi\Component\Exception\InvalidContextException;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Command\EditMockContext;
use Virhi\LazyMockApiBundle\Mock\Application\Factory\MockFactory;

class EditCommand extends AbstractCommand implements CommandInterface
{
    public function execute(ContextInterface $context)
    {
        if (!$context instanceof EditMockContext) {
            throw new InvalidContextException();
        }
        $this->getWriteService()->editMock(MockFactory::build($context->getRequest()));
    }

}