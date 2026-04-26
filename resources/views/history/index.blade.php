<x-app-layout>
    <x-slot name="title">Riwayat Kas</x-slot>

    <!-- SEARCH BAR -->
    <div class="relative">
        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
        </div>
        <input type="text" id="search-input" placeholder="Cari transaksi..." 
            class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 shadow-sm transition-all placeholder:text-gray-300">
    </div>

    <!-- TRANSACTION LIST -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-50" id="transaction-list">
        @include('history.partials.list')
    </div>

    <!-- INFINITE SCROLL SENTINEL -->
    <div id="sentinel" class="py-8 flex justify-center @if(!$transactions->hasMorePages()) hidden @endif">
        <div class="w-6 h-6 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Search Functionality
            const s = document.getElementById('search-input');
            s.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                document.querySelectorAll('.transaction-item').forEach(item => {
                    item.style.display = item.getAttribute('data-description').includes(term) ? 'flex' : 'none';
                });
            });

            // Infinite Scroll Functionality
            let nextPageUrl = "{{ $transactions->nextPageUrl() }}";
            const listContainer = document.getElementById('transaction-list');
            const sentinel = document.getElementById('sentinel');

            if (nextPageUrl) {
                const observer = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting && nextPageUrl) {
                        fetchNextPage();
                    }
                }, { threshold: 0.1 });

                observer.observe(sentinel);

                async function fetchNextPage() {
                    try {
                        const response = await fetch(nextPageUrl, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const html = await response.text();
                        
                        // Append new items
                        listContainer.insertAdjacentHTML('beforeend', html);
                        
                        // Update next page URL from headers or logic (standard Laravel pagination)
                        const parser = new URL(nextPageUrl);
                        let page = parseInt(parser.searchParams.get('page')) + 1;
                        parser.searchParams.set('page', page);
                        
                        // We need to check if there are actually more items. 
                        // Simplified check: if returned HTML is empty or shorter than expected
                        if (html.trim().length === 0) {
                            nextPageUrl = null;
                            sentinel.classList.add('hidden');
                        } else {
                            nextPageUrl = parser.toString();
                        }
                    } catch (error) {
                        console.error('Error fetching next page:', error);
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
