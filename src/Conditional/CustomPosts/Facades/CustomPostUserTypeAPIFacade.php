<?php

declare(strict_types=1);

namespace PoPSchema\Users\Conditional\CustomPosts\Facades;

use PoPSchema\Users\Conditional\CustomPosts\TypeAPIs\CustomPostUserTypeAPIInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class CustomPostUserTypeAPIFacade
{
    public static function getInstance(): CustomPostUserTypeAPIInterface
    {
        return ContainerBuilderFactory::getInstance()->get('custompost_user_type_api');
    }
}
