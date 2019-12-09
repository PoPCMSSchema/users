<?php
namespace PoP\Users\TypeDataResolvers;

use PoP\LooseContracts\Facades\NameResolverFacade;
use PoP\ComponentModel\TypeDataResolvers\AbstractTypeQueryableDataResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;

class UserTypeDataResolver extends AbstractTypeQueryableDataResolver
{
    public function getDataquery()
    {
        return GD_DATAQUERY_USER;
    }

    public function getTypeResolverClass(): string
    {
        return UserTypeResolver::class;
    }

    public function getFilterDataloadingModule(): ?array
    {
        return [\PoP_Users_Module_Processor_FieldDataloads::class, \PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS];
    }

    public function resolveObjectsFromIDs(array $ids): array
    {
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        $ret = array();
        foreach ($ids as $user_id) {
            $ret[] = $cmsusersapi->getUserById($user_id);
        }
        return $ret;
    }

    public function getDataFromIdsQuery(array $ids): array
    {
        $query = array(
            'include' => $ids
        );
        return $query;
    }

    protected function getOrderbyDefault()
    {
        return NameResolverFacade::getInstance()->getName('popcms:dbcolumn:orderby:users:name');
    }

    protected function getOrderDefault()
    {
        return 'ASC';
    }

    protected function getQueryHookName()
    {
        // Get the role either from a provided attr, and allow PoP User Platform to set the default role
        return 'UserTypeDataResolver:query';
    }

    public function executeQuery($query, array $options = [])
    {
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        return $cmsusersapi->getUsers($query, $options);
    }

    public function executeQueryIds($query): array
    {
        // $query['fields'] = 'ID';
        $options = [
            'return-type' => POP_RETURNTYPE_IDS,
        ];
        return (array)$this->executeQuery($query, $options);
    }
}