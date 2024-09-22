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
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-sm">Edit</a>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary btn-sm">Show</a>
                                            </div>
                                            <div class="col-md-3">
                                                <form action="{{ route('users.updateStatus', $user->email) }}" method="post">
                                                    @csrf
                                                    @method('PATCH')

                                                    <input type="hidden" name="status" value="{{ $user->status == 'active' ? 'inactive' : 'active' }}">

                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        {{ $user->status }}
                                                    </button>
                                                </form>
                                                {{-- <form action="{{ route('users.delete', $user->id) }}" method="post"
                                                    onSubmit="if(!confirm('Are you sure delete this data?')){return false;}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form> --}}

                                                {{-- <button id="delete" data-title="{{ $user->name }}"
                                                    href="{{ route('users.delete', $user->id) }}" class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>

                                                <form method="post" id="deleteForm">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" value="" style="display:none;">
                                                </form> --}}
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
                title: "Apakah Anda yakin menghapus data booking member " + title + " ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('deleteForm').action = href;
                    document.getElementById('deleteForm').submit();
                    swal("Data booking member has been deleted!", {
                        icon: "success",
                    });
                }
            });
    });
</script>
@endpush
