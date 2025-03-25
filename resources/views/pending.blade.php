@extends('layouts.fonts', ['main_page' => 'yes'])

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pending Tasks</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pending & Expiring Soon Tasks</h3>
                            </div>
                            <div class="card-body">
                                <div id="task-list">
                                    @include('task_list') {{-- Load the task list via AJAX --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- AJAX Script to Auto Refresh Task List Every 5 Seconds --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Refresh the page every 60 seconds
        setInterval(function() {
            location.reload(); // Reloads the current page
        }, 60000); // 60000 ms = 1 minute
    </script>

@endsection