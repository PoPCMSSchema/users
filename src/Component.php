<?php

declare(strict_types=1);

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

    public static $COMPONENT_DIR;

    // const VERSION = '0.1.0';

    public static function getDependedComponentClasses(): array
    {
        return [
            \PoP\QueriedObject\Component::class,
        ];
    }

    /**
     * All conditional component classes that this component depends upon, to initialize them
     *
     * @return array
     */
    public static function getDependedConditionalComponentClasses(): array
    {
        return [
            \PoP\API\Component::class,
            \PoP\RESTAPI\Component::class,
        ];
    }

    public static function getDependedMigrationPlugins(): array
    {
        return [
            'migrate-users',
        ];
    }

    /**
     * Initialize services
     */
    protected static function doInitialize(
        array $configuration = [],
        bool $skipSchema = false,
        array $skipSchemaComponentClasses = []
    ): void {
        parent::doInitialize($configuration, $skipSchema, $skipSchemaComponentClasses);
        ComponentConfiguration::setConfiguration($configuration);
        self::$COMPONENT_DIR = dirname(__DIR__);
        self::initYAMLServices(self::$COMPONENT_DIR);
        self::maybeInitYAMLSchemaServices(self::$COMPONENT_DIR, $skipSchema);
        ServiceConfiguration::initialize();

        if (class_exists('\PoP\CustomPosts\Component')
            && !in_array(\PoP\CustomPosts\Component::class, $skipSchemaComponentClasses)
        ) {
            \PoP\Users\Conditional\Content\ConditionalComponent::initialize(
                $configuration,
                $skipSchema
            );
        }
        if (class_exists('\PoP\Posts\Component')
            && !in_array(\PoP\Posts\Component::class, $skipSchemaComponentClasses)
        ) {
            \PoP\Users\Conditional\Posts\ConditionalComponent::initialize(
                $configuration,
                $skipSchema
            );
        }
    }

    /**
     * Boot component
     *
     * @return void
     */
    public static function beforeBoot(): void
    {
        parent::beforeBoot();

        // Initialize all classes
        ContainerBuilderUtils::registerTypeResolversFromNamespace(__NAMESPACE__ . '\\TypeResolvers');
        ContainerBuilderUtils::attachFieldResolversFromNamespace(__NAMESPACE__ . '\\FieldResolvers');

        // Initialize all conditional components
        if (class_exists('\PoP\CustomPosts\Component')) {
            \PoP\Users\Conditional\Content\ConditionalComponent::beforeBoot();
        }
        if (class_exists('\PoP\Posts\Component')) {
            \PoP\Users\Conditional\Posts\ConditionalComponent::beforeBoot();
        }
    }
}
