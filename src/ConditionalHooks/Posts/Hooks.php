<?php
namespace PoP\Users\ConditionalHooks\Posts;

use PoP\Engine\Hooks\AbstractHookSet;

class Hooks extends AbstractHookSet
{
    const AUTHOR_RESTFIELDS = 'author.id|name|url';

    protected function init()
    {
        $this->hooksAPI->addFilter(
            'Posts:RESTFields',
            [$this, 'getRESTFields']
        );
    }

    public function getRESTFields($restFields): string
    {
        return $restFields.','.self::AUTHOR_RESTFIELDS;
    }
}
