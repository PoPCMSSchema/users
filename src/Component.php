<?php
namespace PoP\Users;

use PoP\Root\Component\AbstractComponent;
use PoP\Root\Component\YAMLServicesTrait;
use PoP\Root\Container\ContainerBuilderUtils;

/**
 * Initialize component
 */
class Component extends AbstractComponent
{
    use YAMLServicesTrait;

    /**
     * Initialize services
     */
    public static function init()
    {
        parent::init();
        self::initYAMLServices(dirname(__DIR__));
    }

    /**
     * Boot component
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // Initialize all conditional hooks
        if (class_exists('\PoP\Posts\Component')) {
            ContainerBuilderUtils::instantiateNamespaceServices(__NAMESPACE__.'\\ConditionalHooks\\Posts');
        }
    }
}