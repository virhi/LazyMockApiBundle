<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 10:46
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Command;


use Virhi\LazyMockApiBundle\Mock\Domain\Service\Mock\WriteService;

abstract class AbstractCommand
{
    /**
     * @var WriteService
     */
    protected $writeService;

    function __construct(WriteService $writeService)
    {
        $this->writeService = $writeService;
    }

    /**
     * @return WriteService
     */
    public function getWriteService()
    {
        return $this->writeService;
    }

}