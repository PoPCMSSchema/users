<?php
namespace PoP\Users\TypeResolvers;

use PoP\ComponentModel\TypeResolvers\AbstractTypeResolver;
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

class UserTypeResolver extends AbstractTypeResolver
{
    public const TYPE_COLLECTION_NAME = 'users';

    public function getTypeCollectionName(): string
    {
        return self::TYPE_COLLECTION_NAME;
    }

    public function getId($resultItem)
    {
        $cmsusersresolver = \PoP\Users\ObjectPropertyResolverFactory::getInstance();
        $user = $resultItem;
        return $cmsusersresolver->getUserId($user);
    }

    public function getIdFieldTypeDataResolverClass(): string
    {
        return UserTypeDataResolver::class;
    }
}

