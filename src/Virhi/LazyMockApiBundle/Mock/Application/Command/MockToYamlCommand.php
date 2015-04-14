<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 14/04/15
 * Time: 21:37
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Command;

use Virhi\Component\Command\CommandInterface;
use Virhi\Component\Command\Context\ContextInterface;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Writer\YamlWriter;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Writer\YamlWriterContext;

class MockToYamlCommand implements CommandInterface
{
    /**
     * @var YamlWriter
     */
    protected $yamlWriter;

    function __construct(YamlWriter $yamlWriter)
    {
        $this->yamlWriter = $yamlWriter;
    }


    public function execute(ContextInterface $context)
    {
        $this->yamlWriter->write($context);
    }
}