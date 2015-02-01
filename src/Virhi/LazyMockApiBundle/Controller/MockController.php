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
use Virhi\LazyMockApiBundle\Mock\Application\Context\Command\DeleteMockContext;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Command\EditMockContext;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Query\ListMockContext;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Query\MockContext;


class MockController extends Controller
{
    public function indexAction()
    {
        return $this->render('VirhiLazyMockApiBundle:Mock:index.html.twig');
    }

    public function saveMockAction(Request $request)
    {
        $context = new EditMockContext($request);
        $this->get('virhi_lazy_mock_api.application.command.edit')->execute($context);

        return new JsonResponse();
    }

    public function mockAction(Request $request, $url)
    {
        $context = new MockContext($request);
        $result  = $this->get('virhi_lazy_mock_api.application.query.mock')->execute($context);

        return new JsonResponse($result->jsonSerialize());
    }

    public function listMockAction()
    {
        $context = new ListMockContext();
        $result  = $this->get('virhi_lazy_mock_api.application.query.list')->execute($context);

        return new JsonResponse($result);
    }

    public function deleteMockAction(Request $request)
    {
        $context = new DeleteMockContext($request);
        $result  = $this->get('virhi_lazy_mock_api.application.command.delete')->execute($context);

        return new JsonResponse($result);
    }
} 