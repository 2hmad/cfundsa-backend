<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        return DB::table('categories')->get();
    }
    public function createCategories(Request $request)
    {
        // check if category exists
        $category = DB::table('categories')->where('title', $request->category)->first();
        if ($category) {
            return response()->json([
                'alert' => 'التصنيف موجود من قبل'
            ], 400);
        }
        DB::table('categories')->insert([
            'title' => $request->category
        ]);
        return response()->json([
            'alert' => 'Category created successfully'
        ]);
    }
    public function deleteCategories($id)
    {
        DB::table('categories')->where('id', $id)->delete();
        return response()->json([
            'alert' => 'Category deleted successfully'
        ]);
    }
}
