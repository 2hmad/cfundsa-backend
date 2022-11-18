<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Companies;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search($keyword)
    {
        // return search in articles and return companies
        $articles = Articles::where('title', 'like', '%' . $keyword . '%')->orWhere('content', 'like', '%' . $keyword . '%')->get();
        $companies = Companies::where('company_name', 'like', '%' . $keyword . '%')->orWhere('details', 'like', '%' . $keyword . '%')->get();
        return [
            'articles' => $articles,
            'companies' => $companies,
        ];
    }
}
