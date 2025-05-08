<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'legajo',
        'password',
        'roles_id',
        'seccional_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'roles_id');
    }

    public function seccional()
    {
        return $this->belongsTo(Seccional::class, 'seccional_id');
    }

    public function votos()
    {
        return $this->hasMany(Voto::class, 'asistente_id');
    }
}
