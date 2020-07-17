<?php

declare(strict_types=1);

namespace PoP\Users\FieldInterfaces;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldInterfaceResolvers\AbstractSchemaFieldInterfaceResolver;

class WithAuthorFieldInterfaceResolver extends AbstractSchemaFieldInterfaceResolver
{
    public const NAME = 'WithAuthor';

    public function getInterfaceName(): string
    {
        return self::NAME;
    }

    public function getSchemaInterfaceDescription(): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return $translationAPI->__('Entities that have an author', 'queriedobject');
    }

    public static function getFieldNamesToImplement(): array
    {
        return [
            'author',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'author' => SchemaDefinition::TYPE_ID,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function isSchemaFieldResponseNonNullable(TypeResolverInterface $typeResolver, string $fieldName): bool
    {
        switch ($fieldName) {
            case 'author':
                return true;
        }
        return parent::isSchemaFieldResponseNonNullable($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'author' => $translationAPI->__('The entity\'s author', 'queriedobject'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }
}
