<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 14/04/2015
 * Time: 14:42
 */

namespace Virhi\LazyMockApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Filesystem\Filesystem;
use Turf\Component\Exception\RunTimeException;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Request;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Response;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;
use Guzzle\Http\Message\Response as GuzzleResponse;

class ConvertJsonHttpToYamlCommand extends ContainerAwareCommand
{

    protected $url;
    protected $path;
    protected $method;
    protected $yamlInlineLevel;

    protected $availableMethod = array('GET', 'POST', 'PUT', 'DELETE' );



    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->url             = $input->getOption('url');
        $this->path            = $input->getOption('path');
        $this->method          = $input->getOption('method');
        $this->yamlInlineLevel = (int)$input->getOption('yaml-inline-level');
    }

    protected function configure()
    {
        $this
            ->setName('virhi:lazymock:jsonReponseToYaml')
            ->setDescription('convert a json http response to yaml')

            ->addOption(
                'url',
                'u',
                InputOption::VALUE_REQUIRED,
                'url whant to convert'
            )

             ->addOption(
                'method',
                'm',
                InputOption::VALUE_OPTIONAL,
                'http method choose in '. implode('|', $this->availableMethod),
                'GET'
            )

            ->addOption(
                'yaml-inline-level',
                'i',
                InputOption::VALUE_OPTIONAL,
                'choose the yaml inline level',
                5
            )

            ->addOption(
                'path',
                'p',
                InputOption::VALUE_OPTIONAL,
                'the path of file',
                __DIR__.'/../Resources/config'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');
        try {
            $this->convert($input, $output);
        } catch(\Exception $e) {
            $output->writeln('convert error : ' . $e->getMessage());
            $logger->addError($e->getMessage());
        }
    }

    protected function convert(InputInterface $input, OutputInterface $output)
    {
        if (!$this->isAvailableMethod()) {
            throw new RunTimeException('Method http no available.');
        }

        $mock = $this->getMock();
        $this->writeMock($mock, $output);
    }

    protected function writeMock(Mock $mock, OutputInterface $output)
    {
        $dumper       = new Dumper();
        $fs           = new Filesystem();
        $key          = $this->getConvertKey($mock);
        $filename     = $key . '.yml';
        $fullFileName = $this->path . '/' . $filename;
        $result       = array(
            'fixtures' => array(
                'responseContentNeedJsonEncode' => true,
                $key                            => $mock->jsonSerialize(),
            )
        );

        if ($fs->exists($fullFileName)) {
            $fs->remove($fullFileName);
        }

        $fs->dumpFile($fullFileName , $dumper->dump($result, $this->yamlInlineLevel));
        $output->writeln($key . ' mock created');
        if (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
            $output->writeln('You can find it at : ' . $fullFileName);
        }
    }

    /**
     * @param GuzzleResponse $response
     * @return Mock
     */
    protected function buildMock(GuzzleResponse $response)
    {
        $mockRequest = new Request();
        $mockRequest->setUrl($this->getParseUrl()['path']);
        $mockRequest->setMethod($this->method);

        $mockResponse = new Response();
        $mockResponse->setStatus($response->getStatusCode());
        $mockResponse->setContent($response->json());

        return new Mock($mockRequest, $mockResponse);
    }

    /**
     * @return Mock
     */
    protected function getMock()
    {
        $httpClient = $this->getContainer()->get('guzzle.client');
        $request    = $httpClient->get($this->url);
        return $this->buildMock($httpClient->send($request));
    }

    /**
     * @param Mock $mock
     * @return string
     */
    protected function getConvertKey(Mock $mock)
    {
        $keyParams = array(
            $this->method,
            $mock->getId()
        );

        return implode('_', $keyParams);
    }

    /**
     * @return array
     */
    protected function getParseUrl()
    {
        return parse_url($this->url);
    }

    /**
     * @return bool
     */
    protected function isAvailableMethod()
    {
        $result = false;

        if (in_array($this->method, $this->availableMethod)) {
            $result = true;
        }
        return $result;
    }
}