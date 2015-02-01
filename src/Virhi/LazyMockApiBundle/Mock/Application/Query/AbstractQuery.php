<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 10:43
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Query;


use Virhi\LazyMockApiBundle\Mock\Domain\Service\Mock\ReadService;

abstract class AbstractQuery
{
    /**
     * @var ReadService
     */
    protected $readService;

    function __construct(ReadService $readService)
    {
        $this->readService = $readService;
    }

    /**
     * @return ReadService
     */
    public function getReadService()
    {
        return $this->readService;
    }

}