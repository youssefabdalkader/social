<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-100 via-white to-blue-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-96 border border-gray-100">

        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">
            Create Account 🚀
        </h2>

        <form method="POST" action="/register" enctype="multipart/form-data" class="space-y-3">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-lg text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="text" name="name" placeholder="Name"
                class="w-full border border-gray-200 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

            <input type="email" name="email" placeholder="Email"
                class="w-full border border-gray-200 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

            <input type="password" name="password" placeholder="Password"
                class="w-full border border-gray-200 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

            <input type="file" name="image" class="w-full border border-gray-200 p-3 rounded-lg bg-gray-50">

            <button class="bg-blue-500 hover:bg-blue-600 transition text-white w-full p-3 rounded-lg font-semibold">
                Register
            </button>
        </form>

        <p class="text-sm mt-5 text-center text-gray-600">
            Already have an account?
            <a href="/login" class="text-blue-500 hover:underline font-medium">
                Login
            </a>
        </p>

    </div>

</body>

</html>
