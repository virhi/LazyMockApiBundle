<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 25/01/15
 * Time: 20:19
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity;

class Response extends Entity
{
    protected $status;
    protected $content;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }



}