<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 25/01/15
 * Time: 20:19
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity;


class Request extends Entity
{
    protected $url;
    protected $method;
    protected $content;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        if ($content === '') {
            $content = null;
        }
        $this->content = $content;
    }
}