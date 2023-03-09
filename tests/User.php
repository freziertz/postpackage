<?php

namespace Freziertz\PostPackage\Tests;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Freziertz\PostPackage\Traits\HasPosts;
use Freziertz\PostPackage\Tests\UserFactory;
use Illuminate\Notifications\Notifiable;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{
    use HasPosts, Authorizable, Notifiable, Authenticatable, HasFactory;

    protected $guarded = [];

    protected $table = 'users';

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
