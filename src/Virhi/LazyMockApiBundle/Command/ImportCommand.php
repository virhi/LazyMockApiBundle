<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 16:17
 */

namespace Virhi\LazyMockApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Factory\MockFactory;
use Symfony\Component\Finder\Finder;

class ImportCommand extends ContainerAwareCommand
{
    protected $path;

    /**
     * @var Finder
     */
    protected $finder;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->path =  $input->getOption('path');
        $this->finder   =  New Finder();
    }

    protected function configure()
    {
        $this
            ->setName('virhi:lazymock:import')
            ->setDescription('import mock')
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

        $output->writeln('Import mock from file.');
        $output->writeln('');

        $parser      = new Parser();

        foreach ($this->finder->files()->in($this->path)->name('*lazyMockFixtures.yml') as $file) {
            try {
                $fileContent = $parser->parse($file->getContents());
                foreach ($fileContent['fixtures'] as $fixture) {

                    if (is_array($fixture) && array_key_exists('responseContentNeedJsonEncode',$fixture) && $fixture['responseContentNeedJsonEncode'] === true) {
                        $fixture["response"]["content"] = json_encode($fixture["response"]["content"]);
                    }

                    $jsonMock = json_encode($fixture);
                    $this->getContainer()->get('virhi_lazy_mock_api.domain.service.write')->editMock(MockFactory::build($jsonMock));

                }

            } catch (ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }
        }
    }
}