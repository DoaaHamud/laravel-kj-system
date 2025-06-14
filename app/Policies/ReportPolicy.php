<?php

namespace App\Policies;

use App\Models\User;

class ReportPolicy
{
    public function create(User $user)
    {
       return $user->role ==='teacher'|| $user->role === 'admin';
    }
    public function update(User $user)
    {
       return $user->role ==='teacher'|| $user->role === 'admin';
    }
    public function delete(User $user)
    {
       return $user->role ==='teacher'|| $user->role === 'admin';
    }
    public function index(User $user)
    {
       return $user->role ==='mother'|| $user->role === 'teacher' ||$user->role === 'admin';
    } 
}
