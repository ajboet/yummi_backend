<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Login user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        } else {
            return response()->json([
                'message' => 'Successfully logged in.',
                'token' => $user->createToken($user->name)->plainTextToken
            ], 200);
        }
    }

    /**
     * Logout user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signOut(Request $request)
    {
        $token_id = explode('|', $request->bearerToken())[0];
        auth('sanctum')->user()->tokens()->where('id', $token_id)->delete();
        return response()->json(['message' => 'Successfully logged out.'], 200);
    }

    /**
     * Signup user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signUp(Request $request)
    {
        if (! $request->has('name') && $request->has('email')) {
            $name = explode('@', $request->email)[0];
            $request['name'] = $name;
        }
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'cellphone_number' => 'required|unique:users',
            'full_address' => 'required|string'
        ]);

        $user = User::create($request->all());
        $user->email_verified_at = now();
        $user->password = bcrypt($request->password);
        $user->update();
        
        return response()->json(['message' => 'Successfully registered user.'], 201);
    }

    /**
     * Update user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth('sanctum')->user();
        $id = $user->id;

        $request->validate([
            'name' => 'sometimes|string|min:3',
            'email' => 'sometimes|string|email|unique:users,email,'.$id,
            'password' => 'sometimes|string|confirmed',
            'cellphone_number' => 'sometimes|unique:users,cellphone_number,'.$id,
            'full_address' => 'sometimes|string'
        ]);

        $user->fill($request->except('password'));
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->update();
        
        if ($user->wasChanged()) {
            return response()->json(['message' => 'Successfully updated user.'], 200);
        }

        return response()->noContent();
    }
}
