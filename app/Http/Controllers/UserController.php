<?php

namespace App\Http\Controllers;

use App\Models\HobbyDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::orderBy('id', 'desc')->simplePaginate(1);
        $users = User::orderBy('id', 'desc')->paginate(1);
        return view('users.index', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'photo' => 'required',
            'occupation_id' => 'required',
            'gender' => 'required',
            'hobbies' => 'required|array|min:1'
        ]);

        $photo = $request->file('photo');
        if ($request->hasFile('photo')) {
            if ($photo->isValid()) {
                $destinationPath = public_path() . '/files/photos/';
                $photoName = time() . '-' . Str::random(15) . '.' . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $photoName);
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $photo,
            'occupation_id' => $request->occupation_id,
            'gender' => $request->gender
        ]);

        foreach ($request->hobbies as $key => $value) {
            HobbyDetail::create([
                'hobby_id' => $value,
                'user_id' => $user->id
            ]);
        }

        return redirect()->back();
    }

    public function show($id)
    {
        $user = User::find($id);

        // Menggunakan Query Builder
        $hobbies = DB::table('hobby_details')
            ->join('hobbies', 'hobby_details.hobby_id', '=', 'hobbies.id')
            ->join('users', 'hobby_details.user_id', '=', 'users.id')
            ->select('hobbies.name AS hobbyName', 'users.id')
            ->where('users.id', $id)
            ->get();

        return view('users.show', [
            'user' => $user,
            'hobbies' => $hobbies
        ]);
    }
}
