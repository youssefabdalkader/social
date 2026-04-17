<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Social App</title>
<script src="https://cdn.tailwindcss.com"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 text-gray-800">

<!-- NAV -->
<div class="bg-white fixed top-0 w-full z-50 shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center p-3">

        <h1 class="font-bold text-blue-500 text-lg">SocialApp</h1>

        <div class="flex items-center gap-3">
            <img src="{{ auth()->user()->image ? asset('storage/'.auth()->user()->image) : 'https://ui-avatars.com/api/?name='.auth()->user()->name }}"
                 class="w-9 h-9 rounded-full border">

            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500 text-sm">Logout</button>
            </form>
        </div>

    </div>
</div>

<div class="max-w-7xl mx-auto flex gap-5 pt-20 px-4">

<!-- LEFT SIDEBAR -->
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

<!-- CREATE -->
<div class="bg-white p-4 rounded-xl shadow-sm mb-5">
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf

        <textarea name="content"
            class="w-full border p-2 rounded text-sm"
            placeholder="Share something..."></textarea>

        <div class="flex justify-between items-center mt-2">
            <input type="file" name="image" class="text-xs">
            <button class="bg-blue-500 text-white px-4 py-1 rounded text-sm">
                Post
            </button>
        </div>
    </form>
</div>

<!-- POSTS -->
@foreach($posts as $post)

@php
    $liked = $post->likes->where('user_id', auth()->id())->count() > 0;
@endphp

<div id="post-{{ $post->id }}" class="bg-white rounded-xl shadow-sm mb-5 p-4">

    <!-- USER -->
    <div class="flex justify-between items-center">

        <div class="flex items-center gap-2">
            <img src="{{ $post->user->image ? asset('storage/'.$post->user->image) : 'https://ui-avatars.com/api/?name='.$post->user->name }}"
                 class="w-8 h-8 rounded-full">

            <div>
                <p class="text-sm font-semibold">{{ $post->user->name }}</p>
                <span class="text-xs text-gray-400">
                    {{ $post->created_at->diffForHumans() }}
                </span>
            </div>
        </div>

        @if($post->user_id == auth()->id())
        <div class="text-xs flex gap-2">
            <a href="{{ route('posts.edit',$post->id) }}" class="text-yellow-500">Edit</a>
            <form method="POST" action="{{ route('posts.destroy',$post->id) }}">
                @csrf
                @method('DELETE')
                <button class="text-red-500">Delete</button>
            </form>
        </div>
        @endif

    </div>

    <!-- CONTENT -->
    <p class="mt-3 text-sm">{{ $post->content }}</p>

    @if($post->image)
        <img src="{{ asset('storage/'.$post->image) }}"
             class="mt-3 rounded-lg max-h-80 mx-auto">
    @endif

    <!-- COUNTS -->
    <div class="flex justify-between text-xs text-gray-500 mt-3">
        <span>❤️ {{ $post->likes->count() }}</span>
        <span>💬 {{ $post->comments->count() }}</span>
    </div>

    <!-- ACTIONS -->
    <div class="flex gap-6 mt-3 text-sm border-t pt-2">

        <form method="POST" action="{{ route('posts.like',$post->id) }}#post-{{ $post->id }}">
            @csrf
            <button class="{{ $liked ? 'text-red-500 font-bold' : 'text-gray-600' }}">
                👍 Like
            </button>
        </form>

        <button onclick="toggleLikes({{ $post->id }})" class="text-gray-600">
            👀 Likes
        </button>

        <button onclick="toggleComments({{ $post->id }})" class="text-gray-600">
            💬 Comment
        </button>

    </div>

    <!-- LIKES -->
    <div id="likes-box-{{ $post->id }}" class="hidden mt-2 text-xs text-gray-600">
        @foreach($post->likes as $like)
            <div>❤️{{ $like->user->name }}</div>
        @endforeach
    </div>

    <!-- COMMENTS -->
    <div id="comments-{{ $post->id }}" class="hidden mt-3">

        @foreach($post->comments as $comment)
            <div class="bg-gray-100 p-2 rounded mb-1 text-sm">
                <b>{{ $comment->user->name }}</b>: {{ $comment->content }}
            </div>
        @endforeach

        <form method="POST" action="{{ route('comments.store',$post->id) }}#post-{{ $post->id }}">
            @csrf
            <input name="content"
                   class="w-full border p-2 rounded mt-2 text-sm"
                   placeholder="Write comment...">

            <button class="bg-blue-500 text-white px-3 py-1 mt-2 rounded text-sm">
                Send
            </button>
        </form>

    </div>

</div>
@endforeach

</div>

<!-- RIGHT SIDEBAR -->
<div class="w-1/4 space-y-4">

    <div class="bg-white p-4 rounded-xl shadow-sm">
        <h3 class="font-semibold text-sm mb-2">role</h3>
        <p class="text-xs text-gray-500">    {{ auth()->user()->getRoleNames()->first() }}
</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm">
        <h3 class="font-semibold text-sm mb-2">Stats about you</h3>
        <p class="text-xs">Posts: {{ auth()->user()->posts()->count() }}</p>
        <p class="text-xs">Likes: {{ auth()->user()->MytotalLikes() }}</p>
        <p class="text-xs">Comments: {{ auth()->user()->MytotalComments() }}</p>
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
window.onload = function () {

    if (window.location.hash) {

        let id = window.location.hash.replace('#post-', '');

        let commentsBox = document.getElementById('comments-' + id);

        if (commentsBox) {
            commentsBox.classList.remove('hidden');
        }
    }

}
</script>

</body>
</html>
