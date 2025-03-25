@extends('layouts.fonts', ['main_page' => 'yes'])

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1></h1>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Example Row -->
                                    <tr>
                                        @foreach($users as $user)
                                        <td></td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->userType}}</td>
                                            <td>{{$user->department->get_Department}}</td>
                                            <td class="action-icons">
                                                <a href="{{ route('admin.getUser', ['id' => $user->id]) }}" class="text-warning">
                                                    <span class="btn btn-primary"><i class="far fa-eye"></i> View</span>
                                                </a></td>

                                    </tr>
                                    @endforeach
                                    <!-- Add more rows as needed -->
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Department</th>
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

        <!-- /.content -->
    </div>

@endsection
