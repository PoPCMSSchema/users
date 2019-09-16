<?php
namespace PoP\Users\ConditionalHooks\Posts;
use PoP\Hooks\Facades\HooksAPIFacade;

class Hooks
{
    const AUTHOR_RESTFIELDS = 'author.id|name|url';

    public function __construct() {
        HooksAPIFacade::getInstance()->addFilter(
            'Posts:RESTFields',
            [$this, 'getRESTFields']
        );
    }

    public function getRESTFields($restFields): string
    {
        return $restFields.','.self::AUTHOR_RESTFIELDS;
    }
}
