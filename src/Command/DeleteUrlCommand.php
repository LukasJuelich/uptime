<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\UrlService;
use Symfony\Component\Console\Input\InputArgument;

class DeleteUrlCommand extends Command
{
    protected static $defaultName = 'app:delete-url';
    private UrlService $urlService;

    public function __construct(UrlService $urlService)
    {
        parent::__construct();
        $this->urlService = $urlService;
    }

    protected function configure()
    {
        $this
            ->addArgument('urlId', InputArgument::REQUIRED, 'What URL should be deleted?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputUrlId = $input->getArgument('urlId');

        $result = $this->urlService->deleteUrlbyId($inputUrlId);

        if(!$result)
        {
            $output->writeln('URL was not deleted: '.$inputUrlId);
            return Command::FAILURE;
        }
    
        $output->writeln('Deleted URL: '.$inputUrlId);        
        return Command::SUCCESS;
    }
}