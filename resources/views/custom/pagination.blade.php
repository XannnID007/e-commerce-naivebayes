@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Previous Mobile --}}
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    <i class="fas fa-chevron-left mr-2"></i>Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-pink-600 bg-white border border-gray-300 leading-5 rounded-md hover:bg-pink-50 focus:outline-none focus:ring ring-pink-300 focus:border-pink-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    <i class="fas fa-chevron-left mr-2"></i>Previous
                </a>
            @endif

            {{-- Next Mobile --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-pink-600 bg-white border border-gray-300 leading-5 rounded-md hover:bg-pink-50 focus:outline-none focus:ring ring-pink-300 focus:border-pink-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    Next<i class="fas fa-chevron-right ml-2"></i>
                </a>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    Next<i class="fas fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    Menampilkan
                    <span class="font-medium text-pink-600">{{ $paginator->firstItem() }}</span>
                    sampai
                    <span class="font-medium text-pink-600">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-medium text-pink-600">{{ $paginator->total() }}</span>
                    hasil
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-lg shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Previous">
                            <span
                                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-l-lg leading-5"
                                aria-hidden="true">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-pink-600 bg-white border border-gray-300 rounded-l-lg leading-5 hover:bg-pink-50 focus:z-10 focus:outline-none focus:ring ring-pink-300 focus:border-pink-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                            aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-pink-600 border border-pink-600 cursor-default leading-5 shadow-sm">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:bg-pink-50 hover:text-pink-600 focus:z-10 focus:outline-none focus:ring ring-pink-300 focus:border-pink-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                                        aria-label="Go to page {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-pink-600 bg-white border border-gray-300 rounded-r-lg leading-5 hover:bg-pink-50 focus:z-10 focus:outline-none focus:ring ring-pink-300 focus:border-pink-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                            aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Next">
                            <span
                                class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-r-lg leading-5"
                                aria-hidden="true">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
