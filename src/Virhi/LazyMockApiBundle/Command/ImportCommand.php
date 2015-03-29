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
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Console\Helper\ProgressBar;

class ImportCommand extends ContainerAwareCommand
{
    protected $path;

    /**
     * @var Finder
     */
    protected $finder;

    protected $imported;

    protected $notImported;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->path        = $input->getOption('path');
        $this->finder      = New Finder();
        $this->imported    = array();
        $this->notImported = array();
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
        $files  = $this->finder->files()->in($this->path)->name('*lazyMockFixtures.yml');
        if (OutputInterface::VERBOSITY_VERY_VERBOSE <= $output->getVerbosity()) {
            $output->writeln(count($files) . ' to Import');
        }

        $progress = new ProgressBar($output, count($files));
        foreach ($files as $file) {
            $progress->start();
            $this->importFile($input, $output, $file);
            $progress->advance();
        }
        $progress->finish();
        if (OutputInterface::VERBOSITY_VERY_VERBOSE <= $output->getVerbosity()) {
            $output->writeln(count($this->imported)    . ' import mock.');
            if (count($this->notImported) > 0) {
                $output->writeln(count($this->notImported) . ' not import mock.');
                if (OutputInterface::VERBOSITY_DEBUG <= $output->getVerbosity()) {
                    $this->getContainer()->get('logger')->addDebug('mock no imported', $this->notImported);
                }
            }
        }

        $output->writeln('');
        $output->writeln('Import mock is done.');
    }

    protected function importFile(InputInterface $input, OutputInterface $output, SplFileInfo $file)
    {
        $parser = new Parser();
        try {
            if (OutputInterface::VERBOSITY_VERY_VERBOSE <= $output->getVerbosity()) {
                $output->writeln('Import file ' . $file->getFilename());
            }
            $fileContent = $parser->parse($file->getContents());
            foreach ($fileContent['fixtures'] as $fixture) {
                $this->importFixture($input, $output, $fixture);
            }

        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
    }

    protected function importFixture(InputInterface $input, OutputInterface $output, array $fixture)
    {
        $specification = $this->getContainer()->get('virhi_lazy_mock_api.application.specification.import_mock');

        if ($specification->isSatisfiedBy($fixture)) {
            if (array_key_exists('responseContentNeedJsonEncode',$fixture) && $fixture['responseContentNeedJsonEncode'] === true) {
                $fixture["response"]["content"] = json_encode($fixture["response"]["content"]);
            }
            $jsonMock = json_encode($fixture);
            $this->getContainer()->get('virhi_lazy_mock_api.domain.service.write')->editMock(MockFactory::build($jsonMock));
            $this->imported[] = $fixture;
        } else {
            $this->notImported[] = $fixture;
        }
    }
}