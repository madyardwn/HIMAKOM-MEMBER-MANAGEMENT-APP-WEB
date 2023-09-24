<?php

namespace App\Filter;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use TakiElias\Tablar\Menu\Builder;
use TakiElias\Tablar\Menu\Filters\FilterInterface;

class RolePermissionMenuFilter implements FilterInterface
{
    public function transform($item)
    {
        if (!$this->isVisible($item)) {
            return false;
        }

        return $item['header'] ?? $item;
    }

    protected function isVisible($item)
    {
        $user = User::find(Auth::id());

        // Check for roles
        $hasAnyRole = $item['hasAnyRole'] ?? null;
        $hasRole = $item['hasRole'] ?? null;

        if (($hasAnyRole && $user->hasAnyRole($hasAnyRole)) || ($hasRole && $user->hasRole($hasRole))) {
            return true;
        }

        return $this->checkPermissions($item, $user) ?? true;
    }

    protected function checkPermissions($item, $user)
    {
        $hasAnyPermission = $item['hasAnyPermission'] ?? null;
        return $hasAnyPermission ? $user->hasAnyPermission($hasAnyPermission) : null;
    }
}
