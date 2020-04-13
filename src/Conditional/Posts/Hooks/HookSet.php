<?php

declare(strict_types=1);

namespace PoP\Users\Conditional\Posts\Hooks;

use PoP\Engine\Hooks\AbstractHookSet;

class HookSet extends AbstractHookSet
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
        return $restFields . ',' . self::AUTHOR_RESTFIELDS;
    }
}
