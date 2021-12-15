<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\UrlService;
use Symfony\Component\Console\Input\InputArgument;

class CreateUrlCommand extends Command
{
    protected static $defaultName = 'app:create-url';
    private UrlService $urlService ;

    public function __construct(UrlService $urlService)
    {
        parent::__construct();
        $this->urlService = $urlService;
    }

    protected function configure()
    {
        $this
            ->addArgument('url', InputArgument::REQUIRED, 'What URL should be added?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputUrl = $input->getArgument('url');

        $result = $this->urlService->createUrl($inputUrl);

        if(!$result)
        {
            $output->writeln('URL was not added: '.$inputUrl);
            return Command::FAILURE;
        }
        $output->writeln('Added URL: '.$inputUrl);
        return Command::SUCCESS;
    }
}