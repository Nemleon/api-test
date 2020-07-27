<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $fillable = ['name', 'email', 'password', 'role', 'about',];

    protected $hidden = ['password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at',];

    static function getAllUsers() {
        return User::all();
    }

    static function getUserInfo($name)
    {
        return User::where('name', $name)
            ->get();
    }

    static function getUserInfoByEmail($email)
    {
        return User::where('email', $email)
            ->get();
    }

    static function deleteUser($name)
    {
        return User::where('name', $name)
            ->delete();
    }

    static function updateUser($name, array $updateItems)
    {
        return User::where('name', $name)
            ->update($updateItems);
    }

    static function createUser($params)
    {
        $values = $params;
        $numOfValues = count($values);

        if ($numOfValues !== 5) {
            if ($numOfValues === 3) {
                $values['role'] = 'user';
                $values['about'] = 'Напишите о себе!';
            } elseif ($numOfValues === 4) {
                if (array_key_exists('role', $values)) {
                    $values['about']  = 'Напишите о себе!';
                } else {
                    $values['role'] = 'user';
                }
            }
        }

        return User::create([
            'name' => $values['name'],
            'email' => $values['email'],
            'password' => Hash::make($values['password']),
            'role' => $values['role'],
            'about' => $values['about'],
        ]);
    }

}
