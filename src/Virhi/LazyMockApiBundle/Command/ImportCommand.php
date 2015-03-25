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

class ImportCommand extends ContainerAwareCommand
{
    protected $filePath;
    protected $fileName;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->filePath =  $input->getOption('path');
        $this->fileName =  $input->getOption('target');
    }

    protected function configure()
    {
        $this
            ->setName('virhi:lazymock:import')
            ->setDescription('import mock')
            ->addOption(
                'target',
                't',
                InputOption::VALUE_OPTIONAL,
                'the target file',
                'lazyMockFixtures.yml'
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

        $output->writeln('Import mock from file.');
        $output->writeln('');

        $fileLocator = new FileLocator($this->filePath);
        $parser      = new Parser();

        try {
            $fileContent = $parser->parse(file_get_contents($fileLocator->locate($this->fileName)));
            foreach ($fileContent['fixtures'] as $fixture)
            {
                $jsonMock = json_encode($fixture);
                $this->getContainer()->get('virhi_lazy_mock_api.domain.service.write')->editMock(MockFactory::build($jsonMock));
            }

        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
    }
}