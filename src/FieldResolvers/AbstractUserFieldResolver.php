<?php
namespace PoP\Users\FieldResolvers;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

abstract class AbstractUserFieldResolver extends AbstractDBDataFieldResolver
{
    public static function getFieldNamesToResolve(): array
    {
        return [
			'users',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'users' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_ID),
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'users' => $translationAPI->__('IDs of the users', 'pop-users'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function getSchemaFieldArgs(TypeResolverInterface $typeResolver, string $fieldName): array
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        switch ($fieldName) {
            case 'users':
                $schemaDefinitions = $this->getFieldArgumentsSchemaDefinitions($typeResolver, $fieldName);
                // $schemaDefinitions[] = [
                //     SchemaDefinition::ARGNAME_NAME => 'emails',
                //     SchemaDefinition::ARGNAME_TYPE => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_EMAIL),
                //     SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('Filter users by email address', 'users'),
                // ];
                return $schemaDefinitions;
        }
        return parent::getSchemaFieldArgs($typeResolver, $fieldName);
    }

    public function enableOrderedSchemaFieldArgs(TypeResolverInterface $typeResolver, string $fieldName): bool
    {
        switch ($fieldName) {
            case 'users':
                return false;
        }
        return parent::enableOrderedSchemaFieldArgs($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        switch ($fieldName) {
            case 'users':
                $query = [
                    'limit' => -1,
                ];
                // if (isset($fieldArgs['emails'])) {
                //     $query['emails'] = $fieldArgs['emails'];
                // }
                $options = [
                    'return-type' => POP_RETURNTYPE_IDS,
                ];
                $this->addFilterDataloadQueryArgs($options, $typeResolver, $fieldName, $fieldArgs);
                return $cmsusersapi->getUsers($query, $options);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldDefaultTypeDataResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'users':
                return UserTypeDataResolver::class;
        }

        return parent::resolveFieldDefaultTypeDataResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}
