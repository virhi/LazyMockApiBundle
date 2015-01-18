<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 17/01/15
 * Time: 18:51
 */

namespace Virhi\LazyMockApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MockController extends Controller
{
    public function indexAction()
    {
        return $this->render('VirhiLazyMockApiBundle:Mock:index.html.twig');
    }

    public function saveMockAction()
    {
        return new JsonResponse();
    }
} 