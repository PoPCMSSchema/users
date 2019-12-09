<?php
namespace PoP\Users\FieldResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Engine\FieldResolvers\SiteFieldResolverTrait;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\API\TypeResolvers\SiteTypeResolver;
use PoP\Users\FieldResolvers\RootUserFieldResolverTrait;
use PoP\Users\FieldResolvers\AbstractUserFieldResolver;

class SiteUserFieldResolver extends AbstractUserFieldResolver
{
    use SiteFieldResolverTrait, RootUserFieldResolverTrait;

    public static function getClassesToAttachTo(): array
    {
        return array(SiteTypeResolver::class);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'user' => $translationAPI->__('ID of the user', 'pop-users'),
			'users' => $translationAPI->__('IDs of the users in the site', 'pop-users'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }
}
