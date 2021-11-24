<?php

namespace App\Http\Controllers;
use  Illuminate\Support\Facades\Auth;

use App\Models\FirmInformations;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
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
        $FirmInformation = FirmInformations::where('firm_id', Auth::user()->id)->first();

        if ($User->type == 0) {
            $data = [
                "id" => $User->id,
                "email" => $User->email,
                "type" => $User->type == 0 ? 'Üretici' : 'Mağaza',
                "informations" => [
                    'logo' => $FirmInformation->logo,
                    'name' => $FirmInformation->name,
                    'city' => $FirmInformation->city,
                    'town' => $FirmInformation->town,
                    'whatsapp' => $FirmInformation->whatsapp,
                    'phone' => $FirmInformation->phone,
                    'lat' => $FirmInformation->lat,
                    'lang' => $FirmInformation->lang,
                    'area' => $FirmInformation->area,
                    'capacity' => $FirmInformation->capacity,
                    'productionTypes' => unserialize($FirmInformation->productionTypes),
                    'market' => unserialize($FirmInformation->market),
                    'about' => $FirmInformation->about,
                    'address' => $FirmInformation->address,
                ]
            ];
        } else {
            $data = [
                "id" => $User->id,
                "email" => $User->email,
                "type" => $User->type == 0 ? 'Üretici' : 'Mağaza',
                "informations" => [
                    'logo' => $FirmInformation->logo,
                    'name' => $FirmInformation->name,
                    'city' => $FirmInformation->city,
                    'town' => $FirmInformation->town,
                    'whatsapp' => $FirmInformation->whatsapp,
                    'phone' => $FirmInformation->phone,
                    'lat' => $FirmInformation->lat,
                    'lang' => $FirmInformation->lang,
                    'storeAmount' => $FirmInformation->storeAmount,
                    'storeArea' => $FirmInformation->storeArea,
                    'productTypes' => unserialize($FirmInformation->productTypes),
                    'partners' => unserialize($FirmInformation->partners),
                    'about' => $FirmInformation->about,
                    'address' => $FirmInformation->address,
                ]
            ];
        }

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function otherProfile(Request $request)
    {
        $User = User::where('id', $request->id)->first();
        $FirmInformation = FirmInformations::where('firm_id', $request->id)->first();

        if ($User->type == 0) {
            $data = [
                "id" => $User->id,
                "email" => $User->email,
                "type" => $User->type == 0 ? 'Üretici' : 'Mağaza',
                "informations" => [
                    'logo' => $FirmInformation->logo,
                    'name' => $FirmInformation->name,
                    'city' => $FirmInformation->city,
                    'town' => $FirmInformation->town,
                    'whatsapp' => $FirmInformation->whatsapp,
                    'phone' => $FirmInformation->phone,
                    'lat' => $FirmInformation->lat,
                    'lang' => $FirmInformation->lang,
                    'area' => $FirmInformation->area,
                    'capacity' => $FirmInformation->capacity,
                    'productionTypes' => unserialize($FirmInformation->productionTypes),
                    'market' => unserialize($FirmInformation->market),
                    'about' => $FirmInformation->about,
                    'address' => $FirmInformation->address,
                ]
            ];
        } else {
            $data = [
                "id" => $User->id,
                "email" => $User->email,
                "type" => $User->type == 0 ? 'Üretici' : 'Mağaza',
                "informations" => [
                    'logo' => $FirmInformation->logo,
                    'name' => $FirmInformation->name,
                    'city' => $FirmInformation->city,
                    'town' => $FirmInformation->town,
                    'whatsapp' => $FirmInformation->whatsapp,
                    'phone' => $FirmInformation->phone,
                    'lat' => $FirmInformation->lat,
                    'lang' => $FirmInformation->lang,
                    'storeAmount' => $FirmInformation->storeAmount,
                    'storeArea' => $FirmInformation->storeArea,
                    'productTypes' => unserialize($FirmInformation->productTypes),
                    'partners' => unserialize($FirmInformation->partners),
                    'about' => $FirmInformation->about,
                    'address' => $FirmInformation->address,
                ]
            ];
        }

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function allProducers()
    {
        $data = array();
        $Users = User::where('type', 0)->get();
        foreach($Users as $User) {
            $FirmInformation = FirmInformations::where('firm_id', $User->id)->first();
                $info = [
                "id" => $User->id,
                "email" => $User->email,
                "type" => $User->type == 0 ? 'Üretici' : 'Mağaza',
                "informations" => [
                    'logo' => $FirmInformation->logo,
                    'name' => $FirmInformation->name,
                    'city' => $FirmInformation->city,
                    'town' => $FirmInformation->town,
                    'whatsapp' => $FirmInformation->whatsapp,
                    'phone' => $FirmInformation->phone,
                    'lat' => $FirmInformation->lat,
                    'lang' => $FirmInformation->lang,
                    'area' => $FirmInformation->area,
                    'capacity' => $FirmInformation->capacity,
                    'productionTypes' => unserialize($FirmInformation->productionTypes),
                    'market' => unserialize($FirmInformation->market),
                    'about' => $FirmInformation->about,
                    'address' => $FirmInformation->address,
                ]
            ];
                array_push($data, $info);
        }

        return response()->json(['success' => true, 'data' => $data], 200);
    }

}
