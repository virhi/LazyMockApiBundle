<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 14/04/15
 * Time: 21:40
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Writer;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper;


class YamlWriter
{
    protected $dumper;
    protected $fs;

    function __construct(Filesystem $fs)
    {
        $this->fs     = $fs;
        $this->dumper = new Dumper();
    }

    public function write(YamlWriterContext $context)
    {
        $fullFileName = $context->getFullFileName();
        $result       = array(
            'fixtures' => $this->getFileContent($context)
        );

        if ($this->fs->exists($fullFileName)) {
            $this->fs->remove($fullFileName);
        }

        $this->fs->dumpFile($fullFileName , $this->dumper->dump($result, $context->getYamlInlineLevel()));
    }

    protected function getFileContent($context)
    {
        $mock  = $context->getMock()->jsonSerialize();
        $mock['responseContentNeedJsonEncode'] = true;

        $result = array(
            $context->getKey() => $mock
        );

        return $result;
    }
}