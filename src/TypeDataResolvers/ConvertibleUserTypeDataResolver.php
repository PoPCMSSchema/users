<?php
namespace PoP\Users\TypeDataResolvers;

use PoP\Users\TypeDataResolvers\UserTypeDataResolver;
use PoP\Users\TypeResolvers\ConvertibleUserTypeResolver;

class ConvertibleUserTypeDataResolver extends UserTypeDataResolver
{
    public function getTypeResolverClass(): string
    {
        return ConvertibleUserTypeResolver::class;
    }
}

