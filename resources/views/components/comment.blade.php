{{-- COMMENT --}}
<div class="flex space-x-2">
    <img src="{{ $popularComment->user->getMedia('avatar')->last()->getUrl() }}" alt="Profile picture" class="w-9 h-9 rounded-full">
    <div>
        <div class="bg-gray-100 dark:bg-dark-third p-2 rounded-2xl text-sm">
            <span class="font-semibold block">{{ $popularComment->user->name }} {{ $popularComment->id }}</span>
            <span>{{ $popularComment->comment_text }}</span>
        </div>
        <div class="p-2 text-xs text-gray-500 dark:text-dark-txt">
            <span class="font-semibold cursor-pointer">Like</span> <span>.</span>
            <span class="font-semibold cursor-pointer">Reply</span> <span>.</span>
            {{ $popularComment->created_at->diffForHumans() }}
        </div>
        {{-- REPLY --}}
        {{--@if($popularComment->replies)
            @foreach($popularComment->replies as $reply)
                <x-comment :popular-comment="$reply" />
            @endforeach
        @endif--}}
        {{-- END REPLY --}}
    </div>
</div>
{{-- END COMMENT --}}