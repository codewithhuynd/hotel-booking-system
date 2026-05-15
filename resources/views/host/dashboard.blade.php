<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Host Dashboard</title>

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

        /*
        |--------------------------------------------------------------------------
        | LAYOUT
        |--------------------------------------------------------------------------
        */

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

        .welcome{
            margin-bottom: 30px;
        }

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD CARDS
        |--------------------------------------------------------------------------
        */

        .cards{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card{
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card h3{
            margin-bottom: 10px;
            color: #555;
        }

        .card p{
            font-size: 28px;
            font-weight: bold;
            color: #111;
        }

        /*
        |--------------------------------------------------------------------------
        | LOGOUT BUTTON
        |--------------------------------------------------------------------------
        */

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

        <a href="#">
            Manage Bookings
        </a>

        <a href="#">
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

        <div class="welcome">

            <h1>
                Welcome,
                {{ Auth::user()->full_name }}
            </h1>

            <p>
                Hotel Management Dashboard
            </p>

        </div>

        <!-- DASHBOARD STATS -->

        <div class="cards">

            <div class="card">
                <h3>Total Rooms</h3>
                <p>20</p>
            </div>

            <div class="card">
                <h3>Available Rooms</h3>
                <p>12</p>
            </div>

            <div class="card">
                <h3>Occupied Rooms</h3>
                <p>5</p>
            </div>

            <div class="card">
                <h3>Total Bookings</h3>
                <p>30</p>
            </div>

            <div class="card">
                <h3>Today's Bookings</h3>
                <p>4</p>
            </div>

            <div class="card">
                <h3>Pending Payments</h3>
                <p>3</p>
            </div>

        </div>

    </div>

</div>

</body>
</html>