<?php
namespace PoP\Users;

use PoP\Root\Component\AbstractComponent;
use PoP\Root\Container\ContainerBuilderUtils;

/**
 * Initialize component
 */
class Component extends AbstractComponent
{
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
