<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



</head>
<style>
    .logo-text {
        font-family: 'Calibri';
        text-align: center;
    }

    .logo-main {
        font-size: 18px;
        color: #0c84ff;
        font-weight: bold;
        position: relative;
        display: inline-block;
        letter-spacing: 5px;
        line-height: 2px;
    }

</style>
<body>


<aside class="main-sidebar sidebar-dark-primary elevation-4">




    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="info">
              <span class="logo-text">
    <img src="{{ asset('uploads/images/rab.png') }}"  style="width: 170px; height: 120px;"><br>
                 <strong style="color: #0c84ff;font-size: 20px">Coordinator Dashboard</strong>


</span>

            </div>
        </div>



        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

             <li class="nav-item">

                    <a href="{{ route('Coordinator.DashBoard') }}" class="nav-link @if(request()->routeIs('Coordinator.DashBoard'))active @endif ">


                        <i class="fa-solid fa-user"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="nav-item">

                    <a href="{{ route('editor.dashboard') }}" class="nav-link @if(request()->routeIs('editor.dashboard'))active @endif ">


                        <i class="fa-solid fa-user"></i>
                        <p>User Details</p>
                    </a>
                </li>
                <a href="{{ route('coordinator.jobAssign') }}" class="nav-link @if(request()->routeIs('coordinator.jobAssign'))active @endif ">
                    <i class="fa-solid fa-list-check"></i>
                    <p>Assign Task</p>
                </a>

                </li>

                <li>
                    <a href="{{ route('pendingTask.coordinator') }}" class="nav-link @if(request()->routeIs('pendingTask.coordinator'))active @endif ">
                        <i class="fa-solid fa-clock"></i>
                        <p>Pending Task</p>
                    </a>
                </li>

{{--                <li class="nav-item">--}}

{{--                    <a href="{{ route('admin.addDep') }}" class="nav-link @if(request()->routeIs('admin.addDep'))active @endif ">--}}

{{--                        <i class="fa-solid fa-building"></i>--}}

{{--                        <p>Department</p>--}}
{{--                    </a>--}}
{{--                </li>--}}


                {{--                <li class="nav-item">--}}

                {{--                    <a href="{{ route('admin.addPost') }}" class="nav-link @if(request()->routeIs('admin.addPost'))active @endif ">--}}
                {{--                        <i class="nav-icon fas fa-book"></i>--}}
                {{--                        <p>Post</p>--}}
                {{--                    </a>--}}

                {{--                </li>--}}

{{--                <a href="{{ route('admin.assignTask') }}" class="nav-link @if(request()->routeIs('admin.assignTask'))active @endif ">--}}
{{--                    <i class="fa-solid fa-list-check"></i>--}}
{{--                    <p>Assign Task</p>--}}
{{--                </a>--}}

{{--                </li>--}}
                <li class="nav-item">
                    <a href="{{ route('selfUpdate', ['id' => auth()->user()->id]) }}" class="nav-link @if(request()->routeIs('selfUpdate')) active @endif">
                        <i class="fa-solid fa-user-gear"></i>
                        <p>Profile Settings</p>
                    </a>
                </li>
                <hr>
            
                <li> <a class="nav-link" href="{{ route('logout') }}"

                        onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>







            {{--                <li class="nav-item">--}}
            {{--                    <a href=" "--}}
            {{--                       onclick="event.preventDefault();--}}
            {{--                              document.getElementById('logout-form').submit();">--}}
            {{--                        <i class="nav-icon fas fa-sign-out-alt"></i>--}}
            {{--                        {{ __('Logout') }}--}}
            {{--                    </a>--}}

            {{--                    <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">--}}
            {{--                        @csrf--}}
            {{--                    </form>--}}
            {{--                </li>--}}
        </nav>
    </div>
</aside>
</body>
</html>

