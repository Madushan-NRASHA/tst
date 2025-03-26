@extends('layouts.fonts',['main_page' > 'yes'])
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="{{ route('admin.viewUser') }}" style="text-decoration: none">User Details</a></li>
                        </ol>
                    </div>
                </div>
                @if(auth()->user()->  userType != "General Manager")
                <button class="btn btn-primary" style="width: 200px">
                    <a href="{{ route('admin.addUser') }}" class="nav-link">
                        <i class="fas fa-plus"></i> Add User
                    </a>
                </button>
                @endif
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Detail Table</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Emp No</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                             <td>{{ $user->Emp_id }}</td>
                                             <td>{{ $user->department->get_Department}} </td>
                                            <td>{{ $user->userType }}</td>




                                            <td class="action-icons">
                                                <a href="{{ route('admin.view', ['id' => $user->id]) }}" class="text-warning">
                                                    <span class="btn btn-primary"><i class="far fa-eye"></i> View</span>
                                                </a>
                                                <a href="{{ route('admin.editUser', $user->id) }}" class="text-warning">
                                                    <span class="btn btn-warning"><i class="fas fa-edit"></i> Edit</span>
                                                </a>
                                                @if(auth()->user()->  userType != "General Manager")
                                                <a href="{{ route('admin.deleteUser', $user->id) }}" class="text-danger" onclick="confirmDelete(event)">
                                                    <span class="btn btn-danger">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </span>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
{{--                                    @endforeach--}}
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Emp No</th>
                                        <th>Department</th>
                                        <th>Role</th>

                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function confirmDelete(event) {
            event.preventDefault();

            const deleteUrl = event.target.closest('a').href;

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>
@endsection
