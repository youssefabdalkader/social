<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Profile</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gradient-to-b from-blue-50 via-white to-blue-100">

<div class="max-w-xl mx-auto mt-20 bg-white p-6 rounded-xl shadow">


    <h2 class="text-xl font-bold mb-4">Edit Profile</h2>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <!-- NAME -->
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name"
                   value="{{ auth()->user()->name }}"
                   class="w-full border p-2 rounded">
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email"
                   value="{{ auth()->user()->email }}"
                   class="w-full border p-2 rounded">
        </div>

        <!-- IMAGE -->
        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="image" class="w-full">
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Update
        </button>

    </form>

</div>

</body>
</html>
