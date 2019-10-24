<?php
namespace PoP\Users\RouteModuleProcessors;

use PoP\ModuleRouting\AbstractEntryRouteModuleProcessor;
use PoP\ComponentModel\Server\Utils;
use PoP\ComponentModel\Engine_Vars;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\API\Facades\FieldQueryConvertorFacade;
use PoP\Routing\RouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;

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

        // API
        if (!Utils::disableAPI()) {
            $vars = Engine_Vars::getVars();

            // Single
            $ret[UserRouteNatures::USER][] = [
                'module' => [PoP_Users_Module_Processor_FieldDataloads::class, PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_SINGLEUSER_FIELDS],
                'conditions' => [
                    'scheme' => POP_SCHEME_API,
                ],
            ];
            // REST API Single
            $ret[UserRouteNatures::USER][] = [
                'module' => [PoP_Users_Module_Processor_FieldDataloads::class, PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_SINGLEUSER_FIELDS, ['fields' => isset($vars['query']) ? $vars['query'] : self::getRESTFields()]],
                'conditions' => [
                    'scheme' => POP_SCHEME_API,
                    'datastructure' => GD_DATALOAD_DATASTRUCTURE_REST,
                ],
            ];
        }

        return $ret;
    }

    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        // API
        if (!Utils::disableAPI()) {

            $vars = Engine_Vars::getVars();

            // Page
            $routemodules = array(
                POP_USERS_ROUTE_USERS => [PoP_Users_Module_Processor_FieldDataloads::class, PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS],
            );
            foreach ($routemodules as $route => $module) {
                $ret[RouteNatures::STANDARD][$route][] = [
                    'module' => $module,
                    'conditions' => [
                        'scheme' => POP_SCHEME_API,
                    ],
                ];
            }

            // REST API Page
            $routemodules = array(
                POP_USERS_ROUTE_USERS => [PoP_Users_Module_Processor_FieldDataloads::class, PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_USERLIST_FIELDS, ['fields' => isset($vars['query']) ? $vars['query'] : self::getRESTFields()]],
            );
            foreach ($routemodules as $route => $module) {
                $ret[RouteNatures::STANDARD][$route][] = [
                    'module' => $module,
                    'conditions' => [
                        'scheme' => POP_SCHEME_API,
                        'datastructure' => GD_DATALOAD_DATASTRUCTURE_REST,
                    ],
                ];
            }
        }

        return $ret;
    }
}
