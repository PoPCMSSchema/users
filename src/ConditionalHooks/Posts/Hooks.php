<?php
namespace PoP\Users\ConditionalHooks\Posts;
use PoP\Hooks\Facades\HooksAPIFacade;

class Hooks
{
    public function __construct() {
        HooksAPIFacade::getInstance()->addFilter(
            'Posts:RESTFields',
            [$this, 'getRESTFields']
        );
    }

    public function getRESTFields($restFields)
    {
        return $restFields.',author.id|name|url';
    }
}