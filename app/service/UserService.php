<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
  public function create(array $data)
  {
    $data['password'] = Hash::make($data['password']);
    return User::create($data);
  }

  public function update(User $user, array $data)
  {
    if (!empty($data['password'])) {
      $data['password'] = Hash::make($data['password']);
    }

    $user->update($data);

    return $user;
  }

  public function resetPassword(User $user)
  {
    $password = Str::random(8);

    $user->update([
      'password' => Hash::make($password)
    ]);

    return $password;
  }
}