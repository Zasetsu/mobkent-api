<?php

namespace App\Http\Controllers;
use App\Models\FirmInformations;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Storage;


class ProducerController extends Controller
{


    public function register(Request $request)
    {
        //Kullanıcının üretici olduğunu belirttik
        $type = 0;

//        $table->string('name')->nullable();
//            $table->string('logo')->nullable();
//            $table->integer('city')->nullable();
//            $table->integer('town')->nullable();
//            $table->string('whatsapp')->nullable();
//            $table->string('phone')->nullable();
//            $table->string('lat')->nullable();
//            $table->string('lang')->nullable();
//            $table->integer('area')->nullable();
//            $table->integer('capacity')->nullable();
//            $table->string('productionTypes')->nullable();
//            $table->string('market')->nullable();
//            $table->string('about')->nullable();
//            $table->string('address')->nullable();

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'logo' => 'required',
            'name' => 'required',
            'city' => 'required',
            'town' => 'required',
            'whatsapp' => 'required',
            'phone' => 'required',
            'lat' => 'required',
            'lang' => 'required',
            'area' => 'required',
            'capacity' => 'required',
            'productionTypes' => 'required',
            'market' => 'required',
            'about' => 'required',
            'address' => 'required',
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

            $image = $request->logo;  // your base64 encoded
            $img = preg_replace('/^data:image\/\w+;base64,/', '', $image);
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid().'.png';
             Storage::disk('public_uploads')->put('logos/'.$imageName, base64_decode($image));
             $logo = 'uploads/logos/'.$imageName;
            $information = FirmInformations::create([
               'logo' => $logo,
                'name' => $request->name,
                'city' => $request->city,
                'town' => $request->town,
                'whatsapp' => $request->whatsapp,
                'phone' => $request->phone,
                'lat' => $request->lat,
                'lang' => $request->lang,
                'area' => $request->area,
                'capacity' => $request->capacity,
                'productionTypes' => serialize($request->productionTypes),
                'market' => serialize($request->market),
                'about' => $request->about,
                'address' => $request->address,
                'firm_id' => $user->id
            ]);

            return response()->json(['success' => true, 'message' => 'Üretici kaydınız başarıyla gerçekleştirildi.'],200);
        } catch (\Exception $e) {
            return $e->getMessage();
            return response()->json([
                'success' => false,
                'message' => 'Kayıt işlemi sırasında bir hata oluştu.',
            ], 500);
        }


    }
}
