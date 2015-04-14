<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 14/04/15
 * Time: 21:46
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Writer;

use Virhi\Component\Command\Context\ContextInterface;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class YamlWriterContext implements ContextInterface
{
    protected $mock;
    protected $path;
    protected $yamlInlineLevel;
    protected $filename;
    protected $fullFileName;
    protected $key;

    function __construct(Mock $mock, $yamlInlineLevel, $path)
    {
        $this->mock = $mock;
        $this->path = $path;
        $this->yamlInlineLevel = $yamlInlineLevel;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        $keyParams = array(
            $this->mock->getRequest()->getMethod(),
            $this->mock->getId()
        );

        return implode('_', $keyParams);
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->getKey() . '.yml';
    }

    /**
     * @return mixed
     */
    public function getFullFileName()
    {
        return  $this->path . '/' . $this->getFilename();
    }

    /**
     * @return Mock
     */
    public function getMock()
    {
        return $this->mock;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getYamlInlineLevel()
    {
        return $this->yamlInlineLevel;
    }
}