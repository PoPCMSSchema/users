<?php

declare(strict_types=1);

namespace PoP\Users\Config;

use PoP\ComponentModel\Container\ContainerBuilderUtils;
use PoP\Root\Component\PHPServiceConfigurationTrait;

class ServiceConfiguration
{
    use PHPServiceConfigurationTrait;

    protected static function configure()
    {
        // Load API and RESTAPI conditional classes
        if (class_exists('\PoP\API\Component') && \PoP\API\Component::isEnabled()) {
            ContainerBuilderUtils::injectServicesIntoService(
                'route_module_processor_manager',
                'PoP\\Users\\Conditional\\API\\RouteModuleProcessors',
                'add'
            );
        }
        if (class_exists('\PoP\RESTAPI\Component') && \PoP\RESTAPI\Component::isEnabled()) {
            ContainerBuilderUtils::injectServicesIntoService(
                'route_module_processor_manager',
                'PoP\\Users\\Conditional\\RESTAPI\\RouteModuleProcessors',
                'add'
            );
        }

        // Load Posts conditional classes
        if (class_exists('\PoP\Posts\Component')) {
            // Load API and RESTAPI conditional classes
            if (class_exists('\PoP\API\Component') && \PoP\API\Component::isEnabled()) {
                ContainerBuilderUtils::injectServicesIntoService(
                    'route_module_processor_manager',
                    'PoP\\Users\\Conditional\\Posts\\Conditional\\API\\RouteModuleProcessors',
                    'add'
                );
            }
            if (class_exists('\PoP\RESTAPI\Component') && \PoP\RESTAPI\Component::isEnabled()) {
                ContainerBuilderUtils::injectServicesIntoService(
                    'route_module_processor_manager',
                    'PoP\\Users\\Conditional\\Posts\\Conditional\\RESTAPI\\RouteModuleProcessors',
                    'add'
                );
            }
        }
    }
}
