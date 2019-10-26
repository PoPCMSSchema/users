<?php
namespace PoP\Users\Conditional\RESTAPI\RouteModuleProcessors;

use PoP\ModuleRouting\AbstractEntryRouteModuleProcessor;
use PoP\ComponentModel\Engine_Vars;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\API\Facades\FieldQueryConvertorFacade;
use PoP\Routing\RouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\RESTAPI\DataStructureFormatters\RESTDataStructureFormatter;

class EntryRouteModuleProcessor extends AbstractEntryRouteModuleProcessor
{
    private static $restFieldsQuery;
    private static $restFields;
    public static function getRESTFields(): array
    {
        if (is_null(self::$restFields)) {
            self::$restFields = self::getRESTFieldsQuery();
            if (is_string(self::$restFields)) {
                self::$restFields = FieldQueryConvertorFacade::getInstance()->convertAPIQuery(self::$restFields);
            }
        }
        return self::$restFields;
    }
    public static function getRESTFieldsQuery(): string
    {
        if (is_null(self::$restFieldsQuery)) {
            $restFieldsQuery = 'id|name|url';
            if (class_exists('\PoP\Posts\Component')) {
                $restFieldsQuery .= ',posts.id|title|date|url';
            }
            self::$restFieldsQuery = (string) HooksAPIFacade::getInstance()->applyFilters(
                'Users:RESTFields',
                $restFieldsQuery
            );
        }
        return self::$restFieldsQuery;
    }

    public function getModulesVarsPropertiesByNature()
    {
        $ret = array();
        $vars = Engine_Vars::getVars();
        $ret[UserRouteNatures::USER][] = [
            'module' => [\PoP_Users_Module_Processor_FieldDataloads::class, \PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_SINGLEUSER_FIELDS, ['fields' => isset($vars['query']) ? $vars['query'] : self::getRESTFields()]],
            'conditions' => [
                'scheme' => POP_SCHEME_API,
                'datastructure' => RESTDataStructureFormatter::getName(),
            ],
        ];
        return $ret;
    }

    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();
        $vars = Engine_Vars::getVars();
        $routemodules = array(
            POP_USERS_ROUTE_USERS => [\PoP_Users_Module_Processor_FieldDataloads::class, \PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS, ['fields' => isset($vars['query']) ? $vars['query'] : self::getRESTFields()]],
        );
        foreach ($routemodules as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = [
                'module' => $module,
                'conditions' => [
                    'scheme' => POP_SCHEME_API,
                    'datastructure' => RESTDataStructureFormatter::getName(),
                ],
            ];
        }
        return $ret;
    }
}
