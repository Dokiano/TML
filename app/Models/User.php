<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_user',
        'email',
        'password',
        'role',
        'type',
        'divisi',
    ];

    // Define the relationship with Divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi', 'id', 'nama_divisi');
    }
}
