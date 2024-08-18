<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\Occupation;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $occupations = Occupation::select('id', 'name')->get();
        $hobbies = Hobby::select('id', 'name')->get();
        $genderMale = User::MALE;
        $genderFemale = User::FEMALE;

        return view('home', [
            'occupations' => $occupations,
            'hobbies' => $hobbies,
            'genderMale' => $genderMale,
            'genderFemale' => $genderFemale,
        ]);

        // return view('home', array(
        //     'occupations' => $occupations,
        //     'hobbies' => $hobbies,
        // ));

        // return view('home', compact('occupations', 'hobbies'));
    }
}
