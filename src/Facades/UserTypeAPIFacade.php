<?php

declare(strict_types=1);

namespace PoP\Users\Facades;

use PoP\Users\TypeAPIs\UserTypeAPIInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class UserTypeAPIFacade
{
    public static function getInstance(): UserTypeAPIInterface
    {
        return ContainerBuilderFactory::getInstance()->get('user_type_api');
    }
}
