<?php

namespace Ekyna\Bundle\CookieConsentBundle\DependencyInjection;

use Ekyna\Bundle\CookieConsentBundle\Model\Category;
use Ekyna\Bundle\CookieConsentBundle\Model\Position;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Ekyna\Bundle\CookieConsentBundle\DependencyInjection
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ekyna_cookie_consent');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('name')->end()
                ->scalarNode('read_more_route')->defaultNull()->end()
                ->enumNode('position')
                    ->values(Position::getConstants())
                    ->cannotBeEmpty()
                    ->defaultValue(Position::CENTERED)
                ->end()
                ->booleanNode('backdrop')
                    ->defaultFalse()
                ->end()
                ->arrayNode('categories')
                    ->enumPrototype()
                        ->values(Category::getConstants())
                    ->end()
                    ->cannotBeEmpty()
                    ->defaultValue(Category::getDefault())
                ->end()
                ->booleanNode('persist')
                    ->defaultTrue()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
