<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\UrlCheckService;
use Symfony\Component\Console\Input\InputArgument;

class UrlUpTimeCommand extends Command
{
    protected static $defaultName = 'app:url-check';
    private UrlCheckService $urlCheckService;

    public function __construct(UrlCheckService $urlCheckService)
    {
        parent::__construct();
        $this->urlCheckService = $urlCheckService;
    }

    protected function configure()
    {
        $this
            ->addArgument('url', InputArgument::REQUIRED, 'What URL should be checked?')
            ->addArgument('displayAll', InputArgument::OPTIONAL, 'Should all past checks be displayed?')    
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputUrl = $input->getArgument('url');
        $inputDisplayAll = $input->getArgument('displayAll');

        $result = [$this->urlCheckService->checkUrl($inputUrl)];

        if($inputDisplayAll == 'displayAll')
        {
            $result = $this->urlCheckService->getAllUptimeResults($inputUrl);
        }

        if(!$result)
        {
            $output->writeln("Ooops no results found!");
            return Command::FAILURE;
        }

        foreach($result as $res)
        {
            if(!$res)
            {
                $output->writeln("URL: ".$inputUrl." could not be queried!");
                continue;
            }
            $output->writeln("URL: ".$res->getUrl()->getUrlString()." with ID: ".$res->getUrl()->getId()." checked:\r");
            $output->writeln("Time: ".$res->getDate()->format('Y-m-d H:i:s')." Statuscode: ".$res->getStatusCode()."\n");
        }
        
        return Command::SUCCESS;
    }
}