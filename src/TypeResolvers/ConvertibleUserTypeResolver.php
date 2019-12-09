<?php
namespace PoP\Users\TypeResolvers;

use PoP\ComponentModel\TypeResolvers\AbstractConvertibleTypeResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;

class ConvertibleUserTypeResolver extends AbstractConvertibleTypeResolver
{
    public const DATABASE_KEY_NAME = 'convertible-users';

    public function getConvertibleTypeCollectionName(): string
    {
        return self::DATABASE_KEY_NAME;
    }

    protected function getBaseTypeResolverClass(): string
    {
        return UserTypeResolver::class;
    }
}

