<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Validator;

class AccountController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Lütfen email adresinizi giriniz.',
            'email.email' => 'Lütfen geçerli bir email adresi giriniz.',
            'password.required' => 'Lütfen şifrenizi giriniz.',
            'password.min' => 'Şifreniz en az 6 karakter olmalıdır.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        };

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email adresi veya şifre hatalı.',
            ], 401);
        };

        return $this->respondWithToken($token);
    }

    public function profile()
    {
        $User = User::where('id', Auth::user()->id)->first();

        $data = [
            "id" => $User->id,
            "email" => $User->email,
            "name" => $User->name,
            "logo" => $User->logo,
            "city" => $User->city,
            "town" => $User->town,
            "whatsapp" => $User->whatsapp,
            "phone" => $User->phone,
            "coordinates" => $User->coordinates,
            "type" => $User->type == 0 ? 'Üretici' : 'Mağaza',
        ];

        return response()->json(['success' => true, 'data' => $data], 200);
    }
}
