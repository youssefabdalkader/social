<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-50 flex items-center justify-center min-h-screen">

<div class="bg-white p-6 rounded shadow w-96">

    <h2 class="text-xl font-bold mb-4">Login</h2>

    <form method="POST" action="{{ route('auth.login') }}">
        @csrf
    @if ($errors->any())
    <div class="alert alert-danger" style="color:red;">
        <ul>
            @foreach ($errors->all() as $error )
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <input type="email" name="email"
               placeholder="Email"
               class="w-full border p-2 mb-2">

        <input type="password" name="password"
               placeholder="Password"
               class="w-full border p-2 mb-2">

        <button class="bg-blue-500 text-white w-full p-2 rounded">
            Login
        </button>
    </form>

    <!-- 👇 admin login link -->
    <div class="mt-3 text-sm text-center">
        <a href="admin/login" class="text-red-500 hover:underline">
            Login as Admin
        </a>
    </div>
    <!-- 👇 Register link -->
    <div class="mt-3 text-sm text-center">
        <a href= "{{ route('register') }}" class="text-red-500 hover:underline">
            Register
        </a>
    </div>

</div>

</body>
</html>
