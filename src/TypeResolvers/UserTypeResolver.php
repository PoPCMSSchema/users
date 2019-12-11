<?php
namespace PoP\Users\TypeResolvers;

use PoP\ComponentModel\TypeResolvers\AbstractTypeResolver;
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

class UserTypeResolver extends AbstractTypeResolver
{
    public const NAME = 'User';

    public function getTypeName(): string
    {
        return self::NAME;
    }

    public function getId($resultItem)
    {
        $cmsusersresolver = \PoP\Users\ObjectPropertyResolverFactory::getInstance();
        $user = $resultItem;
        return $cmsusersresolver->getUserId($user);
    }

    public function getTypeDataResolverClass(): string
    {
        return UserTypeDataResolver::class;
    }
}

