<?php

declare(strict_types=1);

namespace PoPSchema\Users\Conditional\API\RouteModuleProcessors;

use PoP\ModuleRouting\AbstractEntryRouteModuleProcessor;
use PoP\Routing\RouteNatures;
use PoPSchema\Users\Routing\RouteNatures as UserRouteNatures;

class EntryRouteModuleProcessor extends AbstractEntryRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNature()
    {
        $ret = array();
        $ret[UserRouteNatures::USER][] = [
            'module' => [\PoP_Users_Module_Processor_FieldDataloads::class, \PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_RELATIONALFIELDS_SINGLEUSER],
            'conditions' => [
                'scheme' => POP_SCHEME_API,
            ],
        ];
        return $ret;
    }

    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();
        $routemodules = array(
            POP_USERS_ROUTE_USERS => [\PoP_Users_Module_Processor_FieldDataloads::class, \PoP_Users_Module_Processor_FieldDataloads::MODULE_DATALOAD_RELATIONALFIELDS_USERLIST],
        );
        foreach ($routemodules as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = [
                'module' => $module,
                'conditions' => [
                    'scheme' => POP_SCHEME_API,
                ],
            ];
        }
        return $ret;
    }
}
