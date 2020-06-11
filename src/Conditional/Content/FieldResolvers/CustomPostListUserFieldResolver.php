<?php

declare(strict_types=1);

namespace PoP\Users\Conditional\Content\FieldResolvers;

use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Content\FieldResolvers\AbstractCustomPostListFieldResolver;

class CustomPostListUserFieldResolver extends AbstractCustomPostListFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'contentEntities' => $translationAPI->__('Entries considered “content” (eg: posts, events) by the user', 'pop-users'),
            'contentEntityCount' => $translationAPI->__('Number of entries considered “content” (eg: posts, events) by the user', 'pop-users'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    protected function getQuery(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): array
    {
        $query = parent::getQuery($typeResolver, $resultItem, $fieldName, $fieldArgs);

        $user = $resultItem;
        switch ($fieldName) {
            case 'contentEntities':
            case 'contentEntityCount':
                $query['authors'] = [$typeResolver->getID($user)];
                break;
        }

        return $query;
    }
}
