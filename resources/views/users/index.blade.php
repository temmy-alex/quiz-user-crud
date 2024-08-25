@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            List User
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('home') }}" class="btn btn-success">Add User</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Occupation</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->occupation->name }}</td>
                                    <td>{{ ucfirst($user->gender) }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success">Edit</a>
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary">Show</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <ul class="pagination mt-4">
                {!! $users->links() !!}
            </ul>
        </div>
    </div>
</div>
@endsection
