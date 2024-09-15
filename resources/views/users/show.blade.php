@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            Detail Data User
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('users.list') }}" class="btn btn-success">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <a href="" class="btn btn-success">Show Hobby</a>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td>Name</td>
                                    <td>{{ ucwords($user->name) }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td>Hobbies</td>
                                    <td>
                                        <ul>
                                            @foreach ($hobbies as $hobby)
                                                <li>{{ $hobby->hobbyName }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>{{ ucfirst($user->gender) }}</td>
                                </tr>
                                <tr>
                                    <td>Occupation</td>
                                    <td>{{ ucfirst($user->occupation->name) }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <span
                                            class="badge text-bg-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Document</td>
                                    <td>
                                        <form action="{{ route('users.download',$user->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Download</button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ $user->getPhoto() }}" alt="{{ $user->name }}" class="w-100 h-100">
                        </div>
                    </div>

                    <table class="table" id="table-hobby">
                        <thead>
                          <tr>
                            <th scope="col">Hobby</th>
                            <th scope="col">Name</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>

    </script>
@endpush
