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

        <form method="POST" action="/registerUser" class="p-4 border rounded shadow-sm bg-light">
            @csrf

            <!-- Name -->
            <div class="row">
                <div class="col-6">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @if($errors->has('name'))
                        <div class="text-danger mt-1">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="col-6">
                    <label for="Emp_id" class="form-label">{{ __('Emp id') }}</label>
                    <input id="Emp_id" type="text" name="Emp_id" class="form-control" value="{{ old('Emp_id') }}" required autofocus autocomplete="off">

                    @error('Emp_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <!-- Select Department -->
        <div class="row">
            <!-- Email Address -->
            <div class="col-6">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
                @if($errors->has('email'))
                    <div class="text-danger mt-1">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="col-6">
                <label for="SelectDepartment" class="form-label">{{ __('Select Department') }}</label>
                <select id="SelectDepartment" name="department" class="form-select" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->get_Department }}</option>
                    @endforeach
                </select>

                @if($errors->has('department'))
                    <div class="text-danger mt-1">{{ $errors->first('department') }}</div>
                @endif
            </div>
            <div class="col-6">
                <label for="SelectDepartment" class="form-label">{{ __('Select Role') }}</label>
                <select id="SelectDepartment" name="getRole" class="form-select" required>
                    <option value="">Select Role</option>
                    <option value="Director Board">Director Board</option>
                    <option value="Senior Management">Senior Management</option>
                    <option value="Junior Management">Junior Management</option>
                    <option value="Employee">Employee</option>
                </select>
            </div>
        </div>

            <!-- Password -->
          <div class="row">
              <div class="col-6">
                  <label for="password" class="form-label">{{ __('Password') }}</label>
                  <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
                  @if($errors->has('password'))
                      <div class="text-danger mt-1">{{ $errors->first('password') }}</div>
                  @endif
              </div>

              <!-- Confirm Password -->
              <div class="col-6">
                  <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                  <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                  @if($errors->has('password_confirmation'))
                      <div class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</div>
                  @endif
              </div>
          </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                {{--                    <a class="text-decoration-none text-primary" href="{{ route('login') }}">--}}
                {{--                        {{ __('Already registered?') }}--}}
                {{--                    </a>--}}
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>

    <!-- /.content -->






@endsection