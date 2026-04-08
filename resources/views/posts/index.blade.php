<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex items-center gap-3 px-2 py-1">

    <img
        src="{{ auth()->user()->image
            ? asset('storage/' . auth()->user()->image)
            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
        class="w-8 h-8 rounded-full"
    >

    <div class="flex flex-col">
        <span class="text-sm font-semibold">
            {{ auth()->user()->name }}
        </span>

      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="text-xs text-gray-500 hover:text-gray-700 transition">
              Logout
          </button>
        </form>
    </div>

</div>

<div class="max-w-2xl mx-auto py-10 px-4">

    <!-- Create Post -->
    <div class="bg-white shadow-md rounded-2xl p-5 mb-6">
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <textarea
                name="content"
                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="What's on your mind?"
                required></textarea>

            <button class="bg-blue-500 hover:bg-blue-600 transition text-white px-5 py-2 rounded-lg mt-3">
                Post
            </button>
        </form>
    </div>

    <!-- Posts -->
    @foreach($posts as $post)
        <div class="bg-white shadow-md rounded-2xl p-5 mb-6">

            <!-- User -->
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-bold text-blue-600 text-lg">
                    {{ $post->user->name }}
                </h3>

        @if(auth()->id() === $post->user_id)
    <a href="{{ route('posts.edit', $post->id) }}"
       class="text-blue-500 text-sm">
        Edit
    </a>
@endif
                @if(auth()->id() === $post->user_id)
    <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button class="text-red-500 text-sm">
            Delete
        </button>
    </form>
@endif
                <span class="text-gray-400 text-sm">
                    {{ $post->created_at->diffForHumans() }}
                </span>
            </div>

            <!-- Content -->
            <p class="text-gray-700 my-3 leading-relaxed">
                {{ $post->content }}
            </p>

            <!-- Like -->
            <form method="POST" action="/posts/{{ $post->id }}/like">
                @csrf
                <button class="flex items-center gap-2 text-gray-600 hover:text-red-500 transition">
                    ❤️
                    <span>{{ $post->likes->count() }}</span>
                </button>
            </form>

            <!-- Comments -->
            <div class="mt-4 border-t pt-3 space-y-2">
                @foreach($post->comments as $comment)
                    <div class="bg-gray-50 p-2 rounded-lg">
                        <div class="flex justify-between">
                            <b class="text-sm text-gray-800">
                                {{ $comment->user->name }}
                            </b>

                            <span class="text-xs text-gray-400">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mt-1">
                            {{ $comment->content }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Add Comment -->
            <form method="POST" action="{{ route('comments.store' , $post->id) }}" class="mt-3">
                @csrf
                <input
                    name="content"
                    class="border border-gray-300 w-full p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Write a comment..."
                    required>
            </form>

        </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-6">
        {{ $posts->links() }}
    </div>

</div>

</body>
</html>
