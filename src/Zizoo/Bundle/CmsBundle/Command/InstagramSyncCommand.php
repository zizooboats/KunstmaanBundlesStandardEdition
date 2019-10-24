<?php

namespace Zizoo\Bundle\CmsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstagramSyncCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('zizoo_cms:instagram-sync')
            ->setDescription('Fetches all instagram media later than the last instagram media inserted in database.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $instagramService = $this->getContainer()->get('zizoo_cms_bundle.service.instagram_service');
        $instagramService->syncInstagram();
    }
}
