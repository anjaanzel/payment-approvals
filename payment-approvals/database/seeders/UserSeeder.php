<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->first_name = 'Anja';
        $user->last_name = 'Anzel';
        $user->type = 'APPROVER';
        $user->email = 'aa@gmail.com';
        $user->password = Hash::make('123123');
        $user->save();
        $user->createToken('API Token', ['create-payment', 'approvals'])->plainTextToken;

        $user = new User();
        $user->first_name = 'Jane';
        $user->last_name = 'Doe';
        $user->type = 'APPROVER';
        $user->email = 'jd@gmail.com';
        $user->password = Hash::make('123123');
        $user->save();
        $user->createToken('API Token', ['create-payment', 'approvals'])->plainTextToken;

        $user = new User();
        $user->first_name = 'Michael';
        $user->last_name = 'Scott';
        $user->type = 'APPROVER';
        $user->email = 'ms@gmail.com';
        $user->password = Hash::make('123123');
        $user->save();
        $user->createToken('API Token', ['create-payment', 'approvals'])->plainTextToken;
    }
}
