<?php
namespace PoP\Users\FieldResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Users\TypeResolvers\UserTypeResolver;

class UserFieldResolver extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'username',
            'user-nicename',
            'nicename',
            'name',
            'display-name',
            'firstname',
            'lastname',
            'email',
            'url',
            'endpoint',
            'description',
            'website-url',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'username' => SchemaDefinition::TYPE_STRING,
            'user-nicename' => SchemaDefinition::TYPE_STRING,
            'nicename' => SchemaDefinition::TYPE_STRING,
            'name' => SchemaDefinition::TYPE_STRING,
            'display-name' => SchemaDefinition::TYPE_STRING,
            'firstname' => SchemaDefinition::TYPE_STRING,
            'lastname' => SchemaDefinition::TYPE_STRING,
            'email' => SchemaDefinition::TYPE_EMAIL,
            'url' => SchemaDefinition::TYPE_URL,
            'endpoint' => SchemaDefinition::TYPE_URL,
            'description' => SchemaDefinition::TYPE_STRING,
            'website-url' => SchemaDefinition::TYPE_URL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'username' => $translationAPI->__('User\'s username handle', 'pop-users'),
            'user-nicename' => $translationAPI->__('User\'s nice name', 'pop-users'),
            'nicename' => $translationAPI->__('User\'s nice name', 'pop-users'),
            'name' => $translationAPI->__('Name of the user', 'pop-users'),
            'display-name' => $translationAPI->__('Name of the user as displayed on the website', 'pop-users'),
            'firstname' => $translationAPI->__('User\'s first name', 'pop-users'),
            'lastname' => $translationAPI->__('User\'s last name', 'pop-users'),
            'email' => $translationAPI->__('User\'s email', 'pop-users'),
            'url' => $translationAPI->__('URL of the user\'s profile in the website', 'pop-users'),
            'endpoint' => $translationAPI->__('Endpoint to fetch the user\'s data', 'pop-users'),
            'description' => $translationAPI->__('Description of the user', 'pop-users'),
            'website-url' => $translationAPI->__('User\'s own website\'s URL', 'pop-users'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $cmsusersresolver = \PoP\Users\ObjectPropertyResolverFactory::getInstance();
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        $user = $resultItem;
        switch ($fieldName) {
            case 'username':
                return $cmsusersresolver->getUserLogin($user);

            case 'user-nicename':
            case 'nicename':
                return $cmsusersresolver->getUserNicename($user);

            case 'name':
            case 'display-name':
                return $cmsusersresolver->getUserDisplayName($user);

            case 'firstname':
                return $cmsusersresolver->getUserFirstname($user);

            case 'lastname':
                return $cmsusersresolver->getUserLastname($user);

            case 'email':
                return $cmsusersresolver->getUserEmail($user);

            case 'url':
                return $cmsusersapi->getUserURL($typeResolver->getId($user));

            case 'endpoint':
                return \PoP\API\APIUtils::getEndpoint($typeResolver->resolveValue($resultItem, 'url', $variables, $expressions, $options));

            case 'description':
                return $cmsusersresolver->getUserDescription($user);

            case 'website-url':
                return $cmsusersresolver->getUserWebsiteUrl($user);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
