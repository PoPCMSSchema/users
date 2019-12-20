<?php
namespace PoP\Users\TypeResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Users\TypeDataLoaders\UserTypeDataLoader;
use PoP\ComponentModel\TypeResolvers\AbstractTypeResolver;

class UserTypeResolver extends AbstractTypeResolver
{
    public const NAME = 'User';

    public function getTypeName(): string
    {
        return self::NAME;
    }

    public function getSchemaTypeDescription(): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return $translationAPI->__('Representation of a user', 'users');
    }

    public function getID($resultItem)
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

