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
                                <h3 class="card-title">Post Table</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Role</th>
                                        <th>Activity</th>
                                        <th>Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        {{--                                        @foreach($user->tasks as $task)--}}
                                        @foreach($activities as $activity)
                                        <tr>
                                            <td>{{ $activity->user_id }}</td>
                                            <td>{{ $activity->name}}</td>
                                            <td>{{ $activity->date}}</td>
                                            <td>{{ $activity->time}}</td>
                                            <td>{{ $activity->role}}</td>
                                            <td>{{ $activity->activity}}</td>
                                            <td>{{ $activity->details}}</td>


                                        </tr>
                                        {{--                                    @endforeach--}}
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Role</th>
                                        <th>Activity</th>
                                        <th>Details</th>
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

