<?php

namespace PaulMaxwell\GuestbookBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $builder->root('paul_maxwell_guestbook')
            ->children()
                ->integerNode('page_max_post_count')
                ->defaultValue(5)
                ->end()
                ->scalarNode('admin_email')
                ->end()
            ->end();

        return $builder;
    }
}
