<?php

namespace PaulMaxwell\GuestbookBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PaulMaxwellGuestbookExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (!$config['notification_enabled'] &&
            $container->hasDefinition('paul_maxwell_guestbook_bundle.new_message_notifier')
        ) {
            $container->removeDefinition('paul_maxwell_guestbook_bundle.new_message_notifier');
        }

        $container->setParameter(
            'paulmaxwell_guestbook.page_max_post_count',
            $config['page_max_post_count']
        );
        $container->setParameter(
            'paulmaxwell_guestbook.notification_email_sender',
            $config['notification_email_sender']
        );
        $container->setParameter(
            'paulmaxwell_guestbook.notification_email_receiver',
            $config['notification_email_receiver']
        );
    }
}
