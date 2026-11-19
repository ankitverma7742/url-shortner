<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sembark URL Shortener</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 960px; margin: 30px auto; padding: 0 16px; color: #222; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
        a { color: #2563eb; }
        button, input, select { padding: 6px 10px; }
        button { cursor: pointer; }
        .nav { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .nav form { margin: 0; }
    </style>
</head>
<body>

    <h2>Sembark URL Shortener</h2>

    @auth
        <div class="nav">
            <span>{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
            <a href="{{ route('dashboard') }}">Dashboard</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    @endauth

    <hr>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif

    @yield('content')

</body>
</html>