<x-layouts.app :title="__('ブックマーク一覧')">
  <div class="p-6">
    <h2 class="font-semibold text-xl mb-4">{{ __('ブックマーク一覧') }}</h2>

    @if ($tweets->count())

      @foreach ($tweets as $tweet)
      <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">

        <p>{{ $tweet->tweet }}</p>

        <a href="{{ route('profile.show', $tweet->user) }}">
          <p class="text-sm text-gray-500">
            投稿者: {{ $tweet->user->name }}
          </p>
        </a>

        <a href="{{ route('tweets.show', $tweet) }}"
           class="text-blue-500 hover:text-blue-700">
          詳細を見る
        </a>

        {{-- ブックマーク解除 --}}
        <form action="{{ route('bookmarks.destroy', $tweet) }}" method="POST" class="mt-2">
          @csrf
          @method('DELETE')

          <button type="submit" class="text-red-500 hover:text-red-700">
            ブックマーク解除
          </button>
        </form>

      </div>
      @endforeach

      <div class="mt-4">
        {{ $tweets->links() }}
      </div>

    @else
      <p>ブックマークしたTweetはありません。</p>
    @endif

  </div>
</x-layouts.app>