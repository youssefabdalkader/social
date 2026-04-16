<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Register</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-50 flex items-center justify-center min-h-screen">

<div class="bg-white p-6 rounded shadow w-96">

    <h2 class="text-xl font-bold mb-4">Register</h2>

    <form method="POST" action="/register" enctype="multipart/form-data">
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
        <input type="text" name="name"
               placeholder="Name"
               class="w-full border p-2 mb-2">

        <input type="email" name="email"
               placeholder="Email"
               class="w-full border p-2 mb-2">

        <input type="password" name="password"
               placeholder="Password"
               class="w-full border p-2 mb-2">


        <input type="file" name="image" class="w-full mb-3">

        <button class="bg-blue-500 text-white w-full p-2 rounded">
            Register
        </button>
    </form>

    <p class="text-sm mt-3">
        Already have account? <a href="/login" class="text-blue-500">Login</a>
    </p>

</div>

</body>
</html>
