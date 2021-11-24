<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Validator;

class CategoriesController extends Controller
{
    public function all() {
        $categories = Category::all();

       return response()->json(['success' => true, 'data' => $categories], 200);
    }
}
