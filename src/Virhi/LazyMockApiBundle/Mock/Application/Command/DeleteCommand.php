<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 22/01/15
 * Time: 00:09
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Command;


use Virhi\Component\Command\CommandInterface;
use Virhi\Component\Command\Context\ContextInterface;

class DeleteCommand extends AbstractCommand implements CommandInterface
{
    public function execute(ContextInterface $context)
    {
        $this->getWriteService()->removeMock();
    }

} 