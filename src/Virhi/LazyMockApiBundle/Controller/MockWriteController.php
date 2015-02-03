<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 21:25
 */

namespace Virhi\LazyMockApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Command\DeleteMockContext;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Command\EditMockContext;

class MockWriteController extends Controller
{

    public function saveMockAction(Request $request)
    {
        $context = new EditMockContext($request);
        $this->get('virhi_lazy_mock_api.application.command.edit')->execute($context);

        return new JsonResponse();
    }

    public function deleteMockAction(Request $request)
    {
        $context = new DeleteMockContext($request);
        $result  = $this->get('virhi_lazy_mock_api.application.command.delete')->execute($context);

        return new JsonResponse($result);
    }
}