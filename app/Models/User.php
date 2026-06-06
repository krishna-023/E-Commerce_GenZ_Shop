<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Banner;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',              // admin, super-admin, user
        'profile_picture',
        'permissions',       // optional, store custom JSON permissions
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array', // JSON to array
            'notification_settings' => 'array',
                'addresses' => 'array',


    ];

    /**
     * Check if user has a permission.
     */
   public function hasPermission(?string $permission): bool
{
    if ($this->role === 'super-admin') return true;

    $rolePermissions = config("role_permissions.roles.{$this->role}", []);
    $userPermissions = is_array($this->permissions) ? $this->permissions : json_decode($this->permissions ?? '[]', true);

    if (in_array('all', $rolePermissions, true)) return true;

    return in_array($permission, $rolePermissions, true) || in_array($permission, $userPermissions, true);
}



protected static function booted()
{
    static::created(function ($user) {
        if (empty($user->permissions)) {
            $role = $user->role ?? 'user';

            // Assign default permissions from role_permissions config
            $user->permissions = config("role_permissions.roles.$role", []);

            // Ensure profile permissions are included even if role changes
            $profilePermissions = ['item.profile', 'pages-profile-settings', 'profile.settings.update'];
            $user->permissions = array_unique(array_merge($user->permissions, $profilePermissions));

            $user->save();
        }
    });
}



    /**
     * Relationship example: banners
     */
    public function banners()
    {
        return $this->hasMany(Banner::class);
    }
}
