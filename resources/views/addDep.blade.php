@extends('layouts.fonts',['main_page' > 'yes'])
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
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section class="content">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Add New Department</h3>
                </div>

                <form class="form-horizontal" method="POST" action="{{ route('admin.storeDep') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="categoryName" class="col-sm-2 col-form-label">Department Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="categoryName" name="category_name" placeholder="Enter Department Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Add Department</button>
                        <button type="button" class="btn btn-default float-right" onclick="location.reload();">Cancel</button>
                    </div>
                </form>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Department Table</h3>
                            </div>
                            <div class="card-body">

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($departments as $dep)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dep->get_Department}}</td>
                                            <td class="action-icons">
                                                <a href="{{ route('admin.editCatogary', $dep->id) }}" class="text-warning">
                                                    <span class="btn btn-warning"><i class="fas fa-edit"></i> Edit</span>
                                                </a>
                                                <a href="{{ route('admin.destroyCatogary', $dep->id) }}" class="text-danger" onclick="confirmDelete(event, '{{ route('admin.destroyCatogary', $dep->id) }}')">
                                                    <span class="btn btn-danger"><i class="fas fa-trash"></i> Delete</span>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Category Name</th>
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
        <script>
            function confirmDelete(event, url) {
                event.preventDefault();
                if (confirm('Are you sure you want to delete this department? if You Delete This All Users Within This Department Will Removing AutoMaicly And This action cannot be undone.')) {
                    window.location.href = url;
                }
            }
        </script>

    </div>
@endsection
