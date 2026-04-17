<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Posts</title>
<script src="https://cdn.tailwindcss.com"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gradient-to-b from-blue-50 via-white to-blue-100 text-gray-800">

<!-- NAV -->
<div class="bg-white fixed top-0 w-full z-50 border-b shadow-sm">
    <div class="max-w-6xl mx-auto flex justify-between items-center p-3">

        <h1 class="font-bold text-blue-600">SocialApp</h1>

        <div class="flex items-center gap-3">
            <img src="{{ auth()->user()->image ? asset('storage/'.auth()->user()->image) : 'https://ui-avatars.com/api/?name='.auth()->user()->name }}"
                 class="w-9 h-9 rounded-full">

            <span>{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500 text-sm">Logout</button>
            </form>
        </div>

    </div>
</div>

<div class="max-w-6xl mx-auto flex gap-5 pt-20 px-4">

<!-- PROFILE -->
<!-- SIDEBAR -->
<div class="w-1/4 space-y-4">

    <!-- PROFILE CARD -->
    <div class="bg-white p-4 rounded-xl shadow text-center">

        <img src="{{ auth()->user()->image ? asset('storage/'.auth()->user()->image) : 'https://ui-avatars.com/api/?name='.auth()->user()->name }}"
             class="w-16 h-16 mx-auto rounded-full">

        <h2 class="font-bold mt-2">{{ auth()->user()->name }}</h2>
        <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>

        <hr class="my-3">

        <!-- NAV BUTTONS -->
        <div class="flex flex-col gap-2 text-sm">

            <a href="{{ route('posts.index') }}"
               class="bg-blue-500 text-white py-1 rounded text-center">
               🏠 Home
            </a>

            <a href="{{ route('profile') }}"
               class="bg-gray-200 py-1 rounded text-center">
               📄 My Posts
            </a>

            <a href="
            {{ route('profile.edit') }}
            "
               class="bg-yellow-400 py-1 rounded text-center">
               ✏️ Edit Profile
            </a>

        </div>

        <hr class="my-3">

        <!-- STATS -->
        <p>📝 {{ auth()->user()->posts()->count() }}</p>
        <p>❤️ {{ auth()->user()->totalLikes() }}</p>
        <p>💬 {{ auth()->user()->totalComments() }}</p>

    </div>

</div>
<!-- FEED -->
<div class="w-2/4">

<h2 class="font-bold text-lg mb-4">My Posts</h2>

<!-- POSTS -->
@if(auth()->user()->posts->count() == 0)
    <p class="text-gray-500">You have not created any posts yet.</p>
@endif
@foreach(auth()->user()->posts as $post)

@php
    $liked = $post->likes->where('user_id', auth()->id())->count() > 0;
@endphp

<div id="post-{{ $post->id }}" class="bg-white border p-4 rounded-xl shadow mb-5">

    <!-- USER -->
    <div class="flex justify-between items-center">

        <div class="flex items-center gap-2">
            <img src="{{ auth()->user()->image ? asset('storage/'.auth()->user()->image) : 'https://ui-avatars.com/api/?name='.auth()->user()->name }}"
                 class="w-8 h-8 rounded-full">

            <b>{{ auth()->user()->name }}</b>
        </div>

        <div class="flex gap-2 text-xs">
            <a href="{{ route('posts.edit',$post->id) }}" class="text-yellow-500">Edit</a>

            <form method="POST" action="{{ route('posts.destroy',$post->id) }}">
                @csrf
                @method('DELETE')
                <button class="text-red-500">Delete</button>
            </form>
        </div>

    </div>

    <span class="text-gray-400 text-sm">
        {{ $post->created_at->diffForHumans() }}
    </span>

    <!-- CONTENT -->
    <p class="mt-3">{{ $post->content }}</p>

    @if($post->image)
        <img src="{{ asset('storage/'.$post->image) }}"
             class="mt-3 rounded max-h-96 mx-auto">
    @endif

    <!-- COUNTS -->
    <div class="text-sm text-gray-500 mt-2 flex gap-3">
        <span>❤️ {{ $post->likes->count() }}</span>
        <span>💬 {{ $post->comments->count() }}</span>
    </div>

    <!-- ACTIONS -->
    <div class="flex gap-4 mt-2 text-sm">

        <form method="POST" action="{{ route('posts.like',$post->id) }}#post-{{ $post->id }}">
            @csrf
            <button type="submit"
                class="{{ $liked ? 'text-red-500 font-bold' : 'text-blue-500' }}">
                Like
            </button>
        </form>

        <button onclick="toggleLikes({{ $post->id }})" class="text-gray-600">
            Who liked
        </button>

        <button onclick="toggleComments({{ $post->id }})" class="text-gray-600">
            Comments
        </button>

    </div>

    <!-- LIKES -->
    <div id="likes-box-{{ $post->id }}" class="hidden mt-2 text-xs text-gray-600">
        @foreach($post->likes as $like)
            <div>❤️ {{ $like->user->name }}</div>
        @endforeach
    </div>

    <!-- COMMENTS -->
    <div id="comments-{{ $post->id }}" class="hidden mt-3">

        @foreach($post->comments as $comment)
            <div class="bg-blue-50 border p-2 rounded mb-1">
                <b>{{ $comment->user->name }}</b>: {{ $comment->content }}
            </div>
        @endforeach

        <form method="POST" action="{{ route('comments.store',$post->id) }}">
            @csrf
            <input name="content"
                   class="w-full border p-2 rounded mt-2"
                   placeholder="Write comment...">

            <button class="bg-blue-500 text-white px-3 py-1 mt-2 rounded">
                Send
            </button>
        </form>

    </div>

</div>
@endforeach

</div>

<!-- RIGHT -->
<div class="w-1/4">

    <div class="bg-white border p-4 rounded-xl shadow">

        <h2 class="font-bold mb-3">My Stats 👋</h2>

        <p>📝 Posts: {{ auth()->user()->posts()->count() }}</p>
        <p>❤️ Likes: {{ auth()->user()->totalLikes() }}</p>
        <p>💬 Comments: {{ auth()->user()->totalComments() }}</p>

    </div>

</div>

</div>

<script>
function toggleLikes(id){
    document.getElementById(`likes-box-${id}`).classList.toggle('hidden');
}

function toggleComments(id){
    document.getElementById(`comments-${id}`).classList.toggle('hidden');
}
</script>

</body>
</html>
