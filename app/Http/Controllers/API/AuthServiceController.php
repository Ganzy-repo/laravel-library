<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthServiceController extends Controller
{
    private $user;

    private $roleUser;

    private $membership;

    public function __construct(
        User $user,
        RoleUser $roleUser,
        Membership $membership
    ) {
        $this->user = $user;
        $this->roleUser = $roleUser;
        $this->membership = $membership;
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

        $userData = $this->user->whereEmail($request->email)->first();

        $password_check = Hash::check($request->password, $userData->password);

        if (! $password_check) {
            return response([
                'message' => 'wrong password!',
            ], 401);
        }

        $token = $userData->createToken('token')->plainTextToken;

        return response([
            'message' => 'List categories found!',
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $user = $request->user()->load('role');

        if ($user->role[0]->role_name == 'admin') {

            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'nullable|digits_between:10,14',
                'address' => 'nullable|string|min:10|max255',
                'class_room' => 'required|in:X PPLG,XI PPLG,XII PPLG,XII PPLG 2',
            ]);

            $member = Str::random(10);
            $memberId = Str::upper($member);

            $dataUser = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($memberId),
            ]);

            $this->roleUser->create([
                'user_id' => $dataUser->id,
                'role_id' => 2,
            ]);

            $date = new Carbon;

            $this->membership->create([
                'user_id' => $user->id,
                'member_number' => Str::upper($member),
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'classroom' => $request->classroom,
                'start_register' => $date->now(),
                'validate_until' => $date->addDays(365),
            ]);

            $userData = $this->user->whereEmail($request->email)->first();

            $password_check = Hash::check($request->password, $userData->password);

            if (! $password_check) {
                return response([
                    'message' => 'bener!',
                ], 200);
            }

            $token = $userData->createToken('token')->plainTextToken;

            return response([
                'message' => 'Register Success!',
                'token' => $token,
            ]);

            return response([
                'message' => 'Only Admin Access',
                'token' => $token,
            ]);
        }
    }
}
