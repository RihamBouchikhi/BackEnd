<?php

namespace App\Traits;
use App\Models\Admin;
use App\Models\Intern;
use App\Models\Profile;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Request;

trait Update
{
    public function updateProfile($data,$profile){      
        $validatedData = $data->validate([
        'email' => 'email|unique:profiles,email',
    ]);
        $updateData = array_filter([
            'firstName' => $data['firstName'] ?? null,
            'lastName' => $data['lastName'] ?? null,
            'email' => $validatedData['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'password' => isset($data['password']) ? bcrypt($data['password']) : null,
        ]);
        $profile->update($updateData);
        if ($data->role=='user') {
            $user = $profile->user;
             $updateData = array_filter([
            'academicLevel' => $data['academicLevel'] ?? null,
            'establishment' => $data['establishment'] ?? null,
            'startDate' => $data['startDate'] ?? null,
            'endDate' => $data['endDate'] ?? null,
        ]);
            $user->update($updateData);
        }
        if ($data->role=='intern') {
            $intern = $profile->intern;
             $updateData = array_filter([
            'academicLevel' => $data['academicLevel'] ?? null,
            'establishment' => $data['establishment'] ?? null,
            'startDate' => $data['startDate'] ?? null,
            'endDate' => $data['endDate'] ?? null,
        ]);
            $intern->update($updateData);
        }
        return $profile;
    }
}