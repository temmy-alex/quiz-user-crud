<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // const for set gender value
    const MALE = 'male';
    const FEMALE = 'female';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Mass Assignment ini hanya untuk nilai yang berasal dari form
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'occupation_id',
        'gender',
        'document'
    ];

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
        'password' => 'hashed',
    ];

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function getPhoto()
    {
        return asset('files/'.$this->photo);
        // public/files/photos/namafile
    }

    public function getDocument()
    {
        return asset('files/'.$this->document);
        // public/files/documents/namafile
    }
}
