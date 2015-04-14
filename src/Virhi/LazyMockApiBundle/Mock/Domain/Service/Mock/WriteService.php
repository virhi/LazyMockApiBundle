<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 31/01/15
 * Time: 10:06
 */

namespace Virhi\LazyMockApiBundle\Mock\Domain\Service\Mock;


use Virhi\Component\Repository\AttacherInterface;
use Virhi\Component\Repository\RemoverInterface;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;

class WriteService
{
    /**
     * @var AttacherInterface
     */
    protected $attacher;

    /**
     * @var RemoverInterface
     */
    protected $remover;

    function __construct(AttacherInterface $attacher, RemoverInterface $remover)
    {
        $this->attacher = $attacher;
        $this->remover  = $remover;
    }

    public function editMock(Mock $mock)
    {
        $this->attacher->attach($mock);
    }

    public function removeMock(Mock $mock)
    {
        $this->remover->remove($mock);
    }
}