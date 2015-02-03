<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 17/01/15
 * Time: 18:51
 */

namespace Virhi\LazyMockApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Query\ListMockContext;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Query\RequestMockContext;


class MockController extends Controller
{

    public function listMockAction()
    {
        $context = new ListMockContext();
        $result  = $this->get('virhi_lazy_mock_api.application.query.list')->execute($context);

        return new JsonResponse($result);
    }



    public function mockAction(Request $request, $url)
    {
        $context = new RequestMockContext($request);
        $result  = $this->get('virhi_lazy_mock_api.application.query.request_mock')->execute($context);

        return new JsonResponse($result->jsonSerialize());
    }
} 