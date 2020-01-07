<?php
namespace PoP\Users\Conditional\Posts\Conditional\API\RouteModuleProcessors;

use PoP\ModuleRouting\AbstractEntryRouteModuleProcessor;
use PoP\Users\Routing\RouteNatures;

class EntryRouteModuleProcessor extends AbstractEntryRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        // Author's posts
        $routemodules = array(
            POP_POSTS_ROUTE_POSTS => [\PoP_Users_Posts_Module_Processor_FieldDataloads::class, \PoP_Users_Posts_Module_Processor_FieldDataloads::MODULE_DATALOAD_RELATIONALFIELDS_AUTHORPOSTLIST],
        );
        foreach ($routemodules as $route => $module) {
            $ret[RouteNatures::USER][$route][] = [
                'module' => $module,
                'conditions' => [
                    'scheme' => POP_SCHEME_API,
                ],
            ];
        }
        return $ret;
    }
}
