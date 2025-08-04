@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between items-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default leading-5 rounded-lg">
                <i class="fas fa-chevron-left mr-2"></i>
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-pink-600 bg-white border border-gray-300 leading-5 rounded-lg hover:bg-pink-50 hover:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition ease-in-out duration-150">
                <i class="fas fa-chevron-left mr-2"></i>
                Previous
            </a>
        @endif

        {{-- Page Info --}}
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Halaman <span class="font-medium text-pink-600">{{ $paginator->currentPage() }}</span>
            </p>
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-pink-600 bg-white border border-gray-300 leading-5 rounded-lg hover:bg-pink-50 hover:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition ease-in-out duration-150">
                Next
                <i class="fas fa-chevron-right ml-2"></i>
            </a>
        @else
            <span
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default leading-5 rounded-lg">
                Next
                <i class="fas fa-chevron-right ml-2"></i>
            </span>
        @endif
    </nav>
@endif
