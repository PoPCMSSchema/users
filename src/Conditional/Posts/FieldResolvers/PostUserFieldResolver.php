<?php
namespace PoP\Users\Conditional\Posts\FieldResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Posts\FieldResolvers\AbstractPostFieldResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;

class PostUserFieldResolver extends AbstractPostFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'posts' => $translationAPI->__('Posts by the user', ''),
            'content' => $translationAPI->__('Content by the user', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    protected function getQuery(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): array
    {

        $query = parent::getQuery($typeResolver, $resultItem, $fieldName, $fieldArgs);

        $user = $resultItem;
        switch ($fieldName) {
            case 'posts':
            case 'content':
                $query['authors'] = [$typeResolver->getID($user)];
                break;
        }

        return $query;
    }
}
