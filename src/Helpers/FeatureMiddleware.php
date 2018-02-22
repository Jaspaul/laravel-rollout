<?php

namespace Jaspaul\LaravelRollout\Helpers;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;

class FeatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param array $features
     *
     * @return mixed
     *
     * @throws AuthenticationException
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next, ...$features)
    {
        $this->checkAuthenticated($request);

        $this->protect($request, $features);

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param $request
     * @param array $features
     * @return void
     *
     * @throws AuthorizationException
     */
    protected function protect($request, array $features)
    {
        if (empty($features)) {
            return;
        }

        foreach ($features as $feature) {
            if ($request->user()->featureNotEnabled($feature)) {
                throw new AuthorizationException('Unauthenticated.');
            }
        }
    }

    /**
     * Ensure there is a user to check features against
     *
     * @param $request
     *
     * @throws AuthenticationException
     */
    protected function checkAuthenticated($request)
    {
        if (!$request->user()) {
            throw new AuthenticationException('Unauthenticated.');
        }
    }
}
