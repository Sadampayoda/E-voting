<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function user(Request $request)
    {
        $data =  User::where('name', 'like', '%' . $request->search . '%')->get();
        if($request->search == ''){
            $data = User::all();
        }
        return view('admin.user.search',[
            'data' => $data
        ]);
    }
}
