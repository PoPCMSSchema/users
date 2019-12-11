<?php
namespace PoP\Users\TypeResolvers;

use PoP\ComponentModel\TypeResolvers\AbstractTypeResolver;
use PoP\Users\TypeDataLoaders\UserTypeDataLoader;

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

    public function getTypeDataLoaderClass(): string
    {
        return UserTypeDataLoader::class;
    }
}

