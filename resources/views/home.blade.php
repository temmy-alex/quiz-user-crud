@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            {{ __('Create User') }}
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('users.list') }}" class="btn btn-success">List User</a>
                            {{-- <a href="{{ url('users/list') }}" class="btn btn-success">List User by URL</a> --}}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">

                            @error('name')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">

                            @error('email')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">

                            @error('password')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control">

                            @error('photo')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="document" class="form-label">Document</label>
                            <input type="file" name="document" class="form-control">

                            @error('document')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Occupation</label>
                            <select class="form-select form-select-lg mb-3" name="occupation_id" aria-label="Large select example">
                                <option value="">Choose Occupation</option>
                                @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation->id }}"
                                        {{ old('occupation_id') == $occupation->id ? 'selected' : '' }}>
                                        {{ $occupation->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('occupation_id')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Gender</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="{{ $genderMale }}"
                                    {{ old('gender') == $genderMale ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ ucfirst($genderMale) }}
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="{{ $genderFemale }}"
                                    {{ old('gender') == $genderFemale ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ ucfirst($genderFemale) }}
                                </label>
                            </div>

                            @error('gender')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Hobbies</label>
                            @foreach ($hobbies as $hobby)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hobbies[]" value="{{ $hobby->id }}"
                                        {{ old('hobbies') && in_array($hobby->id, old('hobbies'))? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $hobby->name }}
                                    </label>
                                </div>
                            @endforeach

                            @error('hobbies')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
