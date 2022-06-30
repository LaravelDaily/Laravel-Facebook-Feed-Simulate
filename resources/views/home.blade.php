<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @foreach($posts as $post)
                <div class="shadow bg-white mt-4 rounded-lg">
                    {{-- POST AUTHOR --}}
                    <div class="flex items-center justify-between px-4 py-2">
                        <div class="flex space-x-2 items-center">
                            <img src="{{ $post->user->getMedia('avatar')->last()->getUrl() }}" alt="Profile picture" class="w-10 h-10 rounded-full">
                            <div>
                                <div class="flex font-semibold">
                                    {{ $post->user->name }}
                                    @if($post->user->verified_at)
                                        <svg class="w-3 h-3 bg-blue-500 text-white border rounded-full self-center ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="w-8 h-8 grid place-items-center text-xl text-gray-500 hover:bg-gray-200 dark:text-dark-txt dark:hover:bg-dark-third rounded-full cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </div>
                    </div>
                    {{-- END POST AUTHOR --}}

                    {{-- POST CONTENT --}}
                    <div class="text-justify px-4 py-2">
                        {{ Str::limit($post->post_text, 100) }}
                    </div>
                    {{-- END POST CONTENT --}}

                    @if($post->media->count())
                        {{-- END POST IMAGE --}}
                        <div class="py-2">
                            <img src="{{ $post->getMedia('posts')->last()->getUrl() }}" alt="Post image">
                        </div>
                        {{-- END POST IMAGE --}}
                    @endif

                    {{--- POST REACT --}}
                    <div class="px-4 py-2">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-row-reverse items-center">
                                <div class="flex">
                                    <div class="flex -space-x-2">
                                        @foreach($post->reactions->groupBy('value') as $reaction => $data)
                                            <x-dynamic-component :component="'reactions.' . $reaction" />
                                        @endforeach
                                    </div>
                                    <span class="ml-1 text-gray-500">{{ $post->reactions_count }} reactions</span>
                                </div>
                                <span class="rounded-full grid place-items-center text-2xl -ml-1 text-red-800">
                                    <i class='bx bxs-angry'></i>
                                </span> <span class="rounded-full grid place-items-center text-2xl -ml-1 text-red-500">
                                    <i class='bx bxs-heart-circle'></i>
                                </span>
                                <span class="rounded-full grid place-items-center text-2xl -ml-1 text-yellow-500">
                                    <i class='bx bx-happy-alt'></i>
                                </span>
                            </div>
                            <div class="text-gray-500">
                                @if($post->comments_count)
                                    <span>{{ $post->comments_count }} {{ Str::plural('comments', $post->comments_count) }}</span>
                                @endif

                                @if($post->shared_post_count)
                                    <span>{{ $post->shared_post_count }} {{ Str::plural('Shares', $post->shared_post_count) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{--- END POST REACT --}}

                    {{--- POST ACTION --}}
                    <div class="py-2 px-4">
                        <div class="border border-gray-200 dark:border-dark-third border-l-0 border-r-0 py-1">
                            <div class="flex space-x-2">
                                <div class="w-1/3 flex space-x-2 justify-center items-center hover:bg-gray-100 dark:hover:bg-dark-third text-xl py-2 rounded-lg cursor-pointer text-gray-500 dark:text-dark-txt">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="#000000" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none"></rect>
                                        <path d="M32,104H80a0,0,0,0,1,0,0V208a0,0,0,0,1,0,0H32a8,8,0,0,1-8-8V112A8,8,0,0,1,32,104Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                                        <path d="M80,104l40-80a32,32,0,0,1,32,32V80h61.9a15.9,15.9,0,0,1,15.8,18l-12,96a16,16,0,0,1-15.8,14H80" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                                    </svg>
                                    <span class="text-sm font-semibold">Like</span>
                                </div>
                                <div class="w-1/3 flex space-x-2 justify-center items-center hover:bg-gray-100 dark:hover:bg-dark-third text-xl py-2 rounded-lg cursor-pointer text-gray-500 dark:text-dark-txt">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="#000000" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none"></rect>
                                        <path d="M77.4,201.9l-32.3,27A8,8,0,0,1,32,222.8V64a8,8,0,0,1,8-8H216a8,8,0,0,1,8,8V192a8,8,0,0,1-8,8H82.5A7.8,7.8,0,0,0,77.4,201.9Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                                    </svg>
                                    <span class="text-sm font-semibold">Comment</span>
                                </div>
                                <div class="w-1/3 flex space-x-2 justify-center items-center hover:bg-gray-100 dark:hover:bg-dark-third text-xl py-2 rounded-lg cursor-pointer text-gray-500 dark:text-dark-txt">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    <span class="text-sm font-semibold">Share</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--- END POST ACTION --}}

                    {{-- LIST COMMENT --}}
                    @if($post->comments_count)
                        <div class="py-2 px-4">
                            <x-comment :popularComment="$post->popularComment" />
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
</x-app-layout>
