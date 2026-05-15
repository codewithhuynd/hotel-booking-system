<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            font-family: Arial, sans-serif;
            background: #f5f6fa;
        }

        .container{
            display: flex;
            min-height: 100vh;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        */

        .sidebar{
            width: 250px;
            background: #1e293b;
            color: white;
            padding: 20px;
        }

        .sidebar h2{
            margin-bottom: 30px;
        }

        .sidebar a{
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .sidebar a:hover{
            background: #334155;
        }

        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .content{
            flex: 1;
            padding: 30px;
        }

        .logout-btn{
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #dc2626;
            color: white;
            cursor: pointer;
            margin-top: 20px;
        }

        .logout-btn:hover{
            background: #b91c1c;
        }

    </style>
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <h2>HOST PANEL</h2>

        <a href="{{ route('host.dashboard') }}">
            Dashboard
        </a>

        <a href="{{ route('host.rooms.index') }}">
            Manage Rooms
        </a>

        <a href="{{ route('host.bookings.index') }}">
    Manage Bookings
</a>

        <a href="{{ route('host.payments.index') }}">
    Payments
</a>

        <a href="{{ route('home') }}">
            Home Page
        </a>

        <a href="{{ route('host.register-host.create') }}">
            Create Host Account
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="logout-btn">
                Logout
            </button>
        </form>

    </div>

    <!-- CONTENT -->

    <div class="content">

        @yield('content')

    </div>

</div>

</body>
</html>