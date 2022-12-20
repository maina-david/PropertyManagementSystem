<?php
namespace App\Models\wingu;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable implements MustVerifyEmail
{
   use Notifiable;
   use LaratrustUserTrait;

   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
     'id','name', 'email', 'password','last_login','last_login_ip'
   ];

   /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
   protected $hidden = [
     'password', 'remember_token',
   ];
}
