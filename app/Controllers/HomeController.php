<?php

namespace App\Controllers;

use App\Models\FormData;

class HomeController extends Controller
{
    public function index()
    {
        return fn_view('home', [
            /**
             * Order by length
             */
            'form_data' => FormData::sql('SELECT * FROM :table ORDER BY length ASC'),
//             'form_data' => FormData::all(),
        ]);
    }
}