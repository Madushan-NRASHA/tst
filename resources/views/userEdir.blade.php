@extends('layouts.fonts', ['main_page' => 'yes'])

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!--<section class="content-header">-->
        <!--    <div class="container-fluid">-->
        <!--        <div class="row mb-2">-->
        <!--            <div class="col-sm-6">-->
        <!--                <h1>Edit User</h1>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div><!-- /.container-fluid -->
        <!--</section>-->
  <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="col-sm-12">
                                            <h1 class="text-primary font-weight-bold text-center text-md-left">Edit User Details</h1>
                                        </div>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.viewUser') }}">User Details</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>

            </div>
        </section>
        <!-- Main content -->
       <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit User Details</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('admin.updateUser', $user->id) }}">
                    @csrf

                    <!-- Name -->
                    <div class="row">
                        <div class="col-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" name="name" class="form-control" value="{{$user->name}}" required autofocus autocomplete="name">
                            @if($errors->has('name'))
                                <div class="text-danger mt-1">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <!-- Email Address -->
                        <div class="col-6">
                            <label for="Emp_id" class="form-label">{{ __('Emp id') }}</label>
                            <input id="Emp_id" type="text" name="Emp_id" class="form-control" value="{{ $user->Emp_id }}"  required autofocus autocomplete="off">
                        </div>

                    </div>

                    <!-- Select Department -->
                    <div class="row">
                        <div class="col-6">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{$user->email}}" required autocomplete="username">
                            @if($errors->has('email'))
                                <div class="text-danger mt-1">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="col-6">
                            <label for="SelectDepartment" class="form-label">{{ __('Select Department') }}</label>
                            <select id="SelectDepartment" name="department" class="form-select" required>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->get_Department }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('department'))
                                <div class="text-danger mt-1">{{ $errors->first('department') }}</div>
                            @endif
                        </div>
                        <div class="col-6">
                            <label for="SelectDepartment" class="form-label">{{ __('Select Role') }}</label>
                            <select id="SelectDepartment" name="getRole" class="form-select" required>
                                <option value="{{$user->userType}}">{{$user->userType}}</option>
                                <option value="admin">Admin</option>
                                <option value="Coordinator">Coordinator</option>
                                <option value="User">User</option>
                                <option value="General Maneger">General Maneger</option>
                            </select>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row">
                        <div class="col-6">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" value="" name="password" class="form-control" autocomplete="new-password">
                            @if($errors->has('password'))
                                <div class="text-danger mt-1">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-6">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" type="password" value=""  name="password_confirmation" class="form-control" autocomplete="new-password">
                            @if($errors->has('password_confirmation'))
                                <div class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <!-- /.content -->
@endsection
