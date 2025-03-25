<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  

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
    <img src="{{ asset('uploads/images/rab.png') }}"  style="width: 170px; height: 170px;"><br>
    

    <!-- @csrf
    <input type="file" name="image" id="imageInput" style="display: none;" onchange="previewImage(event)">
    
    <img id="preview" src="{{ Auth::user()->user_img ? asset('storage/' . Auth::user()->user_img) : asset('uploads/images/user_pro.png') }}" 
     style="width: 170px; height: 120px; cursor: pointer; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); display: block; margin-bottom: 10px;" 
     onclick="document.getElementById('imageInput').click();">

    
    <button type="submit">Upload</button>
</form> -->

    @if(Auth::check())
    <p style="color: #0c84ff;font-size: 20px">Welcome, {{ Auth::user()->name }}</p>
@else
    <p>Welcome, Guest!</p>
@endif

                 <strong style="color: #0c84ff;font-size: 20px">User Dashboard</strong>


</span>

            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">

                    <a href="{{ route('user.dashboard') }}" class="nav-link @if(request()->routeIs('user.dashboard'))active @endif ">


                        <i class="fa-solid fa-house"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">

                    <a href="{{ route('dashboard') }}" class="nav-link @if(request()->routeIs('dashboard'))active @endif ">


                        <i class="fa-solid fa-user"></i>
                        <p>View Task</p>
                    </a>
                </li>
                <li class="nav-item">

                    <a href="{{ route('done') }}" class="nav-link @if(request()->routeIs('done'))active @endif ">


                        <i class="fa-solid fa-user"></i>
                        <p>Completed Task</p>
                    </a>
                </li>
                <li class="nav-item">

                <a href="{{ route('selfUpdate', ['id' => auth()->user()->id]) }}" class="nav-link @if(request()->routeIs('selfUpdate')) active @endif">

                <i class="fa-solid fa-user-gear"></i>
                        <p>User Settings</p>
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
                    </form></li>






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

