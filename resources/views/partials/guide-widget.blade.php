{{-- ویجت راهنما: در ادمین همیشه نمایش (این پارشیال فقط از admin/layout فراخوانی می‌شود). وابسته به Vite نیست. --}}
@php
    $guideContext = isset($guideContext) ? $guideContext : null;
    $gw = ['guide_widget_btn_bg' => '#2563eb', 'guide_widget_btn_text' => '#ffffff', 'guide_widget_panel_bg' => '#ffffff', 'guide_widget_panel_header_bg' => '#f9fafb', 'guide_widget_panel_text' => '#111827'];
    $posClasses = 'bottom-6 right-6';
    try {
        $gw = \App\Helpers\PlatformUx::guideWidget();
        $posClasses = \App\Helpers\PlatformUx::guideWidgetPositionClasses();
    } catch (\Throwable $e) {
        // از مقادیر پیش‌فرض بالا استفاده می‌شود
    }
@endphp
<style>
#guide-widget-panel #guide-widget-search {
    width: 100%; padding: 0.6rem 0.75rem; font-size: 0.95rem; font-family: inherit;
    border: 1px solid #cbd5e1; border-radius: 6px; text-align: right; direction: rtl;
    background: #fff; color: #1e293b; transition: border-color 0.15s, box-shadow 0.15s;
}
#guide-widget-panel #guide-widget-search:focus {
    outline: none; border-color: var(--platform-button-primary-bg, #4f46e5);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
}
#guide-widget-panel #guide-widget-search::placeholder { color: #94a3b8; }
#guide-widget-results .guide-loading { color: #64748b; font-size: 0.9rem; padding: 0.5rem 0; display: flex; align-items: center; gap: 0.5rem; }
#guide-widget-results .guide-loading::before { content: ''; width: 16px; height: 16px; border: 2px solid #e2e8f0; border-top-color: var(--platform-button-primary-bg, #4f46e5); border-radius: 50%; animation: guide-spin 0.6s linear infinite; }
@keyframes guide-spin { to { transform: rotate(360deg); } }
#guide-widget-results ul { list-style: none; padding: 0; margin: 0; }
#guide-widget-results ul li { margin-bottom: 0.5rem; }
#guide-widget-results ul li a {
    display: block; padding: 0.65rem 0.85rem; border-radius: 6px; text-decoration: none;
    border: 1px solid #e2e8f0; background: #fff; color: #1e293b; text-align: right; font-size: 0.9rem;
    transition: background 0.15s, border-color 0.15s;
}
#guide-widget-results ul li a:hover { background: #f8fafc; border-color: #cbd5e1; color: var(--platform-link-color, #4f46e5); }
#guide-widget-results .guide-empty, #guide-widget-results .guide-error { font-size: 0.9rem; padding: 0.5rem 0; color: #64748b; }
#guide-widget-results .guide-error { color: #dc2626; }
</style>
<div id="guide-widget" class="fixed {{ $posClasses }}" style="font-family: inherit; z-index: 9997;">
    <button type="button" id="guide-widget-toggle" aria-label="راهنما" class="flex items-center justify-center w-14 h-14 rounded-full shadow-lg transition hover:scale-105" style="background: {{ $gw['guide_widget_btn_bg'] ?? '#2563eb' }}; color: {{ $gw['guide_widget_btn_text'] ?? '#ffffff' }};">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </button>
    <div id="guide-widget-backdrop" class="hidden fixed inset-0" style="z-index: 9998; background: rgba(0,0,0,0.4);" aria-hidden="true"></div>
    <div id="guide-widget-panel" class="hidden fixed top-0 right-0 h-full w-full sm:w-96 border-l border-gray-200 shadow-2xl flex flex-col" style="z-index: 9999; background: {{ $gw['guide_widget_panel_bg'] ?? '#ffffff' }};">
        <div class="flex items-center justify-between p-4 border-b border-gray-200 shrink-0" style="background: {{ $gw['guide_widget_panel_header_bg'] ?? '#f9fafb' }}; color: {{ $gw['guide_widget_panel_text'] ?? '#111827' }};">
            <h2 class="text-lg font-bold">راهنمای استفاده</h2>
            <button type="button" id="guide-widget-close" aria-label="بستن" class="p-2 rounded hover:opacity-80" style="color: inherit;">✕</button>
        </div>
        <div class="p-4 border-b border-gray-100 shrink-0">
            <input type="text" id="guide-widget-search" placeholder="جستجو در راهنما..." dir="rtl" autocomplete="off">
        </div>
        <div id="guide-widget-results" class="flex-1 min-h-0 overflow-y-auto p-4" style="color: {{ $gw['guide_widget_panel_text'] ?? '#111827' }}; background: {{ $gw['guide_widget_panel_bg'] ?? '#ffffff' }};">
            <p class="guide-empty">عبارتی تایپ کنید یا لیست زیر را ببینید.</p>
        </div>
    </div>
</div>
<script>
(function() {
    var searchUrl = @json(route('guide.search'));
    var guideContext = @json($guideContext);
    var toggle = document.getElementById('guide-widget-toggle');
    var panel = document.getElementById('guide-widget-panel');
    var closeBtn = document.getElementById('guide-widget-close');
    var backdrop = document.getElementById('guide-widget-backdrop');
    var searchInput = document.getElementById('guide-widget-search');
    var resultsEl = document.getElementById('guide-widget-results');
    var debounce = null;

    function openPanel() {
        panel.classList.remove('hidden');
        backdrop.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (searchInput.value.trim() === '') fetchResults('');
        searchInput.focus();
    }
    function closePanel() {
        panel.classList.add('hidden');
        backdrop.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function render(pages) {
        if (!pages || pages.length === 0) {
            resultsEl.innerHTML = '<p class="guide-empty">نتیجه‌ای یافت نشد.</p>';
            return;
        }
        resultsEl.innerHTML = '<ul>' + pages.map(function(p) {
            return '<li><a href="' + p.url + '" target="_blank" rel="noopener">' + (p.title || p.slug) + '</a></li>';
        }).join('') + '</ul>';
    }

    function setLoading(loading) {
        if (loading) {
            resultsEl.innerHTML = '<p class="guide-loading">در حال جستجو...</p>';
        }
    }

    function fetchResults(q) {
        var url = searchUrl + (q ? '?q=' + encodeURIComponent(q) : '');
        if (guideContext) url += (url.indexOf('?') >= 0 ? '&' : '?') + 'context=' + encodeURIComponent(guideContext);
        setLoading(true);
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function(r) { return r.json(); })
            .then(function(data) { render(data.pages || []); })
            .catch(function() { resultsEl.innerHTML = '<p class="guide-error">خطا در بارگذاری. دوباره تلاش کنید.</p>'; });
    }

    toggle.addEventListener('click', openPanel);
    closeBtn.addEventListener('click', closePanel);
    backdrop.addEventListener('click', closePanel);
    searchInput.addEventListener('input', function() {
        clearTimeout(debounce);
        var q = this.value.trim();
        debounce = setTimeout(function() { fetchResults(q); }, 300);
    });
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePanel();
    });
})();
</script>
