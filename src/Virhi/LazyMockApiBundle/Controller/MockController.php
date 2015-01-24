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

    public function saveMockAction(Request $request)
    {
        $content = json_decode($request->getContent());
        $key     = md5(json_encode($content->request));

        $redis = $this->container->get('snc_redis.default');
        $redis->set($key, json_encode($content->response));

        return new JsonResponse();
    }

    public function mockAction(Request $request, $url)
    {

        var_dump($url);
        die('default');
        $content = json_decode($request->getContent());
        $key     = md5(json_encode($content->request));

        $redis = $this->container->get('snc_redis.default');

        return new JsonResponse($redis->get($key));
    }
} 