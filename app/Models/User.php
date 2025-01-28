<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
            'work_number',
            'name',
            'lastname',
            'phone',
            'img',
            'email',
            'password',
            'street',
            'ext',
            'int',
            'colony_id',
            'curp',
            'birthdate',
            'birth_place',
            'gender',
            'rfc',
            'nss',
            'can_edit',
    ];

    public function getBusiness()
    {
        $areaUser = AreaUser::where('user_id', $this->id)->with('area')->first();
        if ($areaUser) {
            return $areaUser->area->business_id;
        }

        return 0;
    }

    public function getArea()
    {
        $areaUser = AreaUser::where('user_id', $this->id)->with('area')->first();
        if ($areaUser) {
            return $areaUser->area->id;
        }

        return 0;
    }

    public function getPermission()
    {
        $areauser = AreaUser::where('user_id', $this->id)
            ->with([
                'area.permissions' => function ($query) {
                    $query->leftjoin("modules as md", "md.id", "=", 'module_id')
                        ->select('md.id', 'area_id', 'module_id', 'name');
                }
            ])->first();
        if ($areauser) {
            return $areauser->area->permissions;
        }
        return 0;
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
