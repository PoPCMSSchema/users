<?php
namespace PoP\Users;

use PoP\Root\Component\AbstractComponent;
use PoP\Root\Component\YAMLServicesTrait;
use PoP\Users\Config\ServiceConfiguration;
use PoP\ComponentModel\Container\ContainerBuilderUtils;

/**
 * Initialize component
 */
class Component extends AbstractComponent
{
    use YAMLServicesTrait;
    // const VERSION = '0.1.0';

    /**
     * Initialize services
     */
    public static function init()
    {
        parent::init();
        self::initYAMLServices(dirname(__DIR__));
        ServiceConfiguration::init();
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
            ContainerBuilderUtils::instantiateNamespaceServices(__NAMESPACE__.'\\Conditional\\Posts\\Hooks');
        }
    }
}
