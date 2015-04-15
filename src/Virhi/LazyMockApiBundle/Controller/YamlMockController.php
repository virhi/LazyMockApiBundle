<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 14/04/15
 * Time: 23:14
 */

namespace Virhi\LazyMockApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Query\MockContext;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Writer\YamlWriterContext;
use Symfony\Component\HttpFoundation\Response;

class YamlMockController extends Controller
{
    public function getMockYamlAction($key)
    {
        $context = new MockContext($key);
        $mock  = $this->get('virhi_lazy_mock_api.application.query.mock')->execute($context);
        $path  = $this->get('kernel')->getRootDir() . '/../web' ;

        $yamlContext = new YamlWriterContext($mock, 5, $path);
        $this->get('virhi_lazy_mock_api.application.command.mock_to_yaml')->execute($yamlContext);

        $response = new Response();
        $response->headers->set('Content-type', 'application/octect-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $yamlContext->getFilename()));
        $response->headers->set('Content-Length', filesize($yamlContext->getFilename()));
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->setContent(readfile($yamlContext->getFilename()));

        return $response;
    }
}