<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 25/01/15
 * Time: 22:34
 */

namespace Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity;


class Mock extends Entity
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getId()
    {
        return md5(json_encode($this->request));
    }

}