<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $fillable = ['title', 'name', 'gender', 'phone_number', 'image', 'email'];

    public function address()
    {
        return $this->hasMany(Address::class);
    }
}
