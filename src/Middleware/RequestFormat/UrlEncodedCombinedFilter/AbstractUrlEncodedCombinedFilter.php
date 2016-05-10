<?php

namespace Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter;

use Psr\Http\Message\ServerRequestInterface as Request;

class AbstractUrlEncodedCombinedFilter
{
    const URL_KEY = 'Put something here in child';

    protected function getValue(Request $request)
    {
        $params = $request->getQueryParams();

        if (!array_key_exists('filter', $params)
            || !array_key_exists(static::URL_KEY, $params['filter'])
        ) {
            //Nothing in params for us so leave
            return null;
        }

        return $params['filter'][static::URL_KEY];
    }
}
