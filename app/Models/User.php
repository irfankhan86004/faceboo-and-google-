<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Notifiable;
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'display_name', 'url', 'twitter', 'facebook', 'github', 'google', 'linkedin', 'resume_cv', 'address', 'city', 'country', 'bio', 'job', 'phone', 'gender', 'relationship', 'birthday', 'email', 'password'];

    public function getId()
        {
          return $this->id;
        }
     public function isAdmin()
        {
           $admin_number = $this->is_admin;
           if($admin_number==0)
           {
            return 0;
           }
           else {
            return 1; // this looks for an admin column in your users table
            }
        }
}
