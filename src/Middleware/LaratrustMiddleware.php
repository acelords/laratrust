<?php

declare(strict_types=1);

namespace Laratrust\Middleware;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laratrust\Helper;

class LaratrustMiddleware
{
    const DELIMITER = '|';
    protected $roleOrPermissionBeingChecked = [];
    protected $isRoleOrPermission;

    /**
     * Check if the request has authorization to continue.
     */
    protected function authorization(
        string $type,
        string|array $rolesPermissions,
        ?string $team,
        ?string $options
    ): bool {
        [
            'team' => $team,
            'require_all' => $requireAll,
            'guard' => $guard,
        ] = $this->getValuesFromParameters($team, $options);
        $method = $type == 'roles' ? 'hasRole' : 'hasPermission';
        $rolesPermissions = Helper::standardize($rolesPermissions, true);

        if (!is_array($rolesPermissions)) {
            $rolesPermissions = explode(self::DELIMITER, $rolesPermissions);
        }

        $this->roleOrPermissionBeingChecked = $rolesPermissions;
        $this->isRoleOrPermission = $type;

        return !Auth::guard($guard)->guest()
            && Auth::guard($guard)->user()->$method($rolesPermissions, $team, $requireAll);
    }

    /**
     * The request is unauthorized, so it handles the aborting/redirecting.
     */
    protected function unauthorized(): mixed
    {
        $handling = Config::get('laratrust.middleware.handling');
        $handler = Config::get("laratrust.middleware.handlers.{$handling}");

        if ($handling == 'abort') {
            $shouldDisplayRolesPermissionsBeingChecked = Config::get("laratrust.display_roles_permissions_being_checked");

            $defaultMessage = 'User does not have any of the necessary access rights.';
            $message = $handler['message'] ?? $defaultMessage;

            if($shouldDisplayRolesPermissionsBeingChecked)
                $message .= " | " . ucwords($this->isRoleOrPermission) . ": " . implode(", ", $this->roleOrPermissionBeingChecked);

            return App::abort($handler['code'], $message);
        }

        $redirect = Redirect::to($handler['url']);
        if (! empty($handler['message']['content'])) {
            $redirect->with($handler['message']['key'], $handler['message']['content']);
        }

        return $redirect;
    }

    /**
     * Generate an array with the values of the parameters given to the middleware.
     */
    protected function getValuesFromParameters(?string $team, ?string $options): array
    {
        return [
            'team' => Str::contains((string) $team, ['require_all', 'guard:']) ? null : $team,
            'require_all' => Str::contains((string) $team, 'require_all') ?: Str::contains((string) $options, 'require_all'),
            'guard' => Str::contains((string) $team, 'guard:')
                ? $this->extractGuard($team)
                : (
                    Str::contains((string) $options, 'guard:')
                    ? $this->extractGuard($options)
                    : Config::get('auth.defaults.guard')
                ),
        ];
    }

    /**
     * Extract the guard type from the given string.
     */
    protected function extractGuard(string $string): string
    {
        $options = Collection::make(explode('|', $string));

        return $options
            ->reject(fn ($option) => ! Str::contains($option, 'guard:'))
            ->map(fn ($option) => Str::of($option)->explode(':')->get(1))
            ->first();
    }
}
