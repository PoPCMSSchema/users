<?php
namespace PoP\Users\Config;

use PoP\ComponentModel\Container\ContainerBuilderUtils;
use PoP\Root\Component\PHPServiceConfigurationTrait;

class ServiceConfiguration
{
    use PHPServiceConfigurationTrait;

    protected static function configure()
    {
        // Add RouteModuleProcessors to the Manager
        ContainerBuilderUtils::injectServicesIntoService(
            'route_module_processor_manager',
            'PoP\\Users\\RouteModuleProcessors',
            'add'
        );

        // If Posts is also installed
        if (class_exists('\PoP\Posts\Component')) {
            ContainerBuilderUtils::injectServicesIntoService(
                'route_module_processor_manager',
                'PoP\\Users\\Conditional\\Posts\\RouteModuleProcessors',
                'add'
            );
        }
    }
}
