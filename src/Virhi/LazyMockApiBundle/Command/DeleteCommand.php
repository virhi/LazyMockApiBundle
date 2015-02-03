<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 01/02/15
 * Time: 22:02
 */

namespace Virhi\LazyMockApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\InputOption;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Command\DeleteListContext;

class DeleteCommand extends ContainerAwareCommand
{
    protected $key;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->key =  $input->getOption('key');
    }

    protected function configure()
    {
        $this
            ->setName('virhi:lazymock:delete')
            ->setDescription('the mock key')
            ->addOption(
                'key',
                'k',
                InputOption::VALUE_OPTIONAL,
                'the mock key',
                'ALL'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Delete mock');
        $output->writeln('');

        $command = $this->getContainer()->get('virhi_lazy_mock_api.application.command.delete_list');
        $all     = true;
        $keys    = array();

        if ($this->key !== 'ALL') {
            $all = false;
            $keys = explode('-', $this->key);
        }

        $context = new DeleteListContext($all, $keys);
        $command->execute($context);
    }
}