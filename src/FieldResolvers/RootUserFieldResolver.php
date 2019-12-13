<?php
namespace PoP\Users\FieldResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\API\TypeResolvers\RootTypeResolver;
use PoP\Users\FieldResolvers\RootUserFieldResolverTrait;
use PoP\Users\FieldResolvers\AbstractUserFieldResolver;

class RootUserFieldResolver extends AbstractUserFieldResolver
{
    use RootUserFieldResolverTrait;

    public static function getClassesToAttachTo(): array
    {
        return array(RootTypeResolver::class);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'user' => $translationAPI->__('User with a specific ID', 'pop-users'),
			'users' => $translationAPI->__('Users in the current site', 'pop-users'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }
}
