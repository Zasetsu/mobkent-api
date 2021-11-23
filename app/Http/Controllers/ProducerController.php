<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;


class ProducerController extends Controller
{


    public function register(Request $request)
    {
        //Kullanıcının üretici olduğunu belirttik
        $type = 0;



        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Lütfen email adresinizi giriniz.',
            'email.unique' => 'Bu email adresi zaten kullanılıyor.',
            'email.email' => 'Lütfen geçerli bir email adresi giriniz.',
            'password.required' => 'Lütfen şifrenizi giriniz.',
            'password.min' => 'Şifreniz en az 6 karakter olmalıdır.',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            $user = User::create([
                'email' => $request->email,
                'password' => app('hash')->make($request->password),
                'type' => $type
            ]);
            return response()->json(['success' => true, 'message' => 'Üretici kaydınız başarıyla gerçekleştirildi.'],200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kayıt işlemi sırasında bir hata oluştu.',
            ], 500);
        }
    }
}
