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
                                        <div class="row">
                                            <div class="col-md-3">
                                                <form action="{{ route('users.restoreData', $user->id) }}" method="post">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        Restore
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $('button#delete').on('click', function () {
        var href = $(this).attr('href');
        var title = $(this).data('title');

        swal({
                title: "Apakah Anda yakin restore data " + title + " ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('deleteForm').action = href;
                    document.getElementById('deleteForm').submit();
                    swal("Data berhasil di restore!", {
                        icon: "success",
                    });
                }
            });
    });
</script>
@endpush
