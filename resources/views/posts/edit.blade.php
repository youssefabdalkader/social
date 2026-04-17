<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-10 bg-white p-5 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-4">Edit Post</h2>

    <form method="POST" action="{{ route('posts.update', $post->id) }}">
        @csrf
        @method('PUT')
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <textarea name="content"
            class="w-full border p-2 rounded"
            required>{{ $post->content }}</textarea>

        <button class="bg-blue-500 text-white px-4 py-2 mt-3 rounded">
            Update
        </button>
    </form>

</div>

</body>
</html>
