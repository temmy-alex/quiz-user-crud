<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\HobbyDetail;
use App\Models\Occupation;
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
            'name' => 'required|min:5|max:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'photo' => 'required|mimes:png,jpg,jpeg,gif',
            'document' => 'required|mimes:pdf,csv,xls,xlsx|max:1024', // maksimal 1 mb
            'occupation_id' => 'required',
            'gender' => 'required',
            'hobbies' => 'required|array|min:1'
        ], [
            'name.max' => 'Nama tidak boleh lebih dari 10 karakter',
            'name.required' => 'Nama tidak boleh kosong!',
            'name.min' => 'Nama minimal 5 karakter!',
            'photo.mimes' => 'Extension / file hanya diizinkan png,jpg,jpeg,gif',
            'hobbies.required' => 'Minimal harus diisi 1'
        ]);

        // Handling Image
        $photo = $request->file('photo');
        if ($request->hasFile('photo')) {
            if ($photo->isValid()) {
                $destinationPath = public_path() . '/files/photos/';
                $photoFile = time() . '-' . Str::random(15) . '.' . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $photoFile);
                $photoName = '/files/products/'.$photoFile;
            }
        }

        // Handling Document
        $document = $request->file('document');
        if ($request->hasFile('document')) {
            if ($document->isValid()) {
                $destinationPath = public_path() . '/files/documents/';
                $documentFile = time() . '-' . Str::random(15) . '.' . $document->getClientOriginalExtension();
                $document->move($destinationPath, $documentFile);
                $documentName = '/files/products/'.$documentFile;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $photoName,
            'document' => $documentName,
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

    public function edit($id)
    {
        $user = User::find($id);
        $occupations = Occupation::select('id', 'name')->get();
        $hobbies = Hobby::select('id', 'name')->get();
        $hobbiesDetails = HobbyDetail::where('user_id', $id)->get()->pluck('hobby_id')->toArray();
        $genderMale = User::MALE;
        $genderFemale = User::FEMALE;
        return view('users.edit', [
            'user' => $user,
            'occupations' => $occupations,
            'hobbies' => $hobbies,
            'genderMale' => $genderMale,
            'genderFemale' => $genderFemale,
            'hobbiesDetails' => $hobbiesDetails,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:5|max:10',
            'email' => 'required|email',
            'password' => 'confirmed',
            'photo' => 'mimes:png,jpg,jpeg,gif',
            'document' => 'mimes:pdf,csv,xls,xlsx|max:1024', // maksimal 1 mb
            'occupation_id' => 'required',
            'gender' => 'required',
            'hobbies' => 'required|array|min:1'
        ], [
            'name.max' => 'Nama tidak boleh lebih dari 10 karakter',
            'name.required' => 'Nama tidak boleh kosong!',
            'name.min' => 'Nama minimal 5 karakter!',
            'photo.mimes' => 'Extension / file hanya diizinkan png,jpg,jpeg,gif',
            'hobbies.required' => 'Minimal harus diisi 1'
        ]);

        $user = User::find($id);

        // Handling Image
        $photo = $request->file('photo');
        if ($request->hasFile('photo')) {
            if ($photo->isValid()) {
                $destinationPath = public_path() . '/files/photos/';
                $photoFile = time() . '-' . Str::random(15) . '.' . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $photoFile);
                $photoName = '/files/products/'.$photoFile;
            }
        } else {
            $photoName = $user->photo;
        }

        // Handling Document
        $document = $request->file('document');
        if ($request->hasFile('document')) {
            if ($document->isValid()) {
                $destinationPath = public_path() . '/files/documents/';
                $documentFile = time() . '-' . Str::random(15) . '.' . $document->getClientOriginalExtension();
                $document->move($destinationPath, $documentFile);
                $documentName = '/files/documents/'.$documentFile;
            }
        } else {
            $documentName = $user->document;
        }

        if ($request->password == null) {
            $password = $user->password;
        } else {
            $password = bcrypt($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'photo' => $photoName,
            'document' => $documentName,
            'occupation_id' => $request->occupation_id,
            'gender' => $request->gender
        ]);

        $hobbyDetails = HobbyDetail::where('user_id', $id)->get();
        foreach ($hobbyDetails as $hobbyDetail) {
            $hobbyDetail->delete();
        }

        foreach ($request->hobbies as $key => $value) {
            HobbyDetail::create([
                'hobby_id' => $value,
                'user_id' => $user->id
            ]);
        }

        return redirect()->back();
    }

    public function downloadFile($id)
    {
        // SELECT * FROM users WHERE id = $id;
        $user = User::find($id);

        // Misal data tidak ditemukan maka dia akan memberikan response 404 / not found
        if (!$user) {
            abort(404);
        }

        // Membaca path : public/files/documents/namafile
        $file = public_path() . '/files/' . $user->document;

        // Function file_exists merupakan fungsi bawaan php yang digunakan untuk
        // melakukan pengecekkan apakah file yang dicari ada atau tidak
        // Jika filenya tidak ada maka akan menampillkan response 404 / not fund
        if (!file_exists($file)) {
            abort(404, 'File not found.');
        }

        // Mendapatkan nama file nya
        $filename = basename($file);

        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->download($file, $filename, $headers);
    }
}
