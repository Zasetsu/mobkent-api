<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'text' => 'required',
            'coverImage' => 'required'
        ], [
            'name.required' => 'Lütfen başlık giriniz.',
            'text.required' => 'Lütfen açıklama giriniz.',
            'coverImage.required' => 'Lütfen kapak görseli girin.',
        ]);

        try {

            $image = $request->logo;  // your base64 encoded
            $img = preg_replace('/^data:image\/\w+;base64,/', '', $image);
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.png';
            Storage::disk('public_uploads')->put('urunler/' . $imageName, base64_decode($image));
            $logo = 'upload/products/' . $imageName;


            $user = Product::create([
                'name' => $request->name,
                'text' => $request->text,
                'category' => $request->category,
                'secondCategory' => $request->secondCategory,
                'coverImage' => $logo,
                'firm_id' => Auth::user()->id,
            ]);


            return response()->json(['success' => true, 'message' => 'Ürün kaydınız başarıyla gerçekleştirildi.'], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
            return response()->json([
                'success' => false,
                'message' => 'Ürün ekleme işlemi sırasında bir hata oluştu.',
            ], 500);
        }
    }

    public function userProducts(Request $request)
    {
        $Products = Product::where('firm_id', $request->id)->withCount('views')->get();
        return response()->json(['success' => true, 'data' => $Products], 200);

    }

    public function allProducts()
    {

        $Product = Product::withCount('views')->get();
        return response()->json(['success' => true, 'data' => $Product], 200);

    }
public function details(Request $request) {
    $Product = Product::where('id', $request->id)->withCount('views')->first();
        $app = new Review();
        $app->product_id = $request->id;
        $app->user_id = Auth::user()->id;
        $app->save();
    return response()->json(['success' => true, 'data' => $Product], 200);
}

}

