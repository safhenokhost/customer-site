@php
    $theme = \App\Helpers\PlatformUx::allTheme();
    $font = \App\Helpers\PlatformUx::allFont();
@endphp
@for($i = 1; $i <= 5; $i++)
    @if(!empty($font['font_custom_' . $i . '_url']))
        <link rel="stylesheet" href="{{ $font['font_custom_' . $i . '_url'] }}" crossorigin="anonymous">
    @endif
@endfor
<style id="platform-theme">
:root {
    --platform-primary: {{ $theme['theme_primary'] ?? '#4f46e5' }};
    --platform-secondary: {{ $theme['theme_secondary'] ?? '#6366f1' }};
    --platform-menu-bg: {{ $theme['theme_menu_bg'] ?? '#ffffff' }};
    --platform-menu-text: {{ $theme['theme_menu_text'] ?? '#374151' }};
    --platform-menu-link-active: {{ $theme['theme_menu_link_active'] ?? '#2563eb' }};
    --platform-title-color: {{ $theme['theme_title_color'] ?? '#111827' }};
    --platform-link-color: {{ $theme['theme_link_color'] ?? '#4f46e5' }};
    --platform-link-hover: {{ $theme['theme_link_hover'] ?? '#4338ca' }};
    --platform-sidebar-bg: {{ $theme['theme_sidebar_bg'] ?? '#ffffff' }};
    --platform-sidebar-text: {{ $theme['theme_sidebar_text'] ?? '#374151' }};
    --platform-sidebar-active-bg: {{ $theme['theme_sidebar_active_bg'] ?? '#eff6ff' }};
    --platform-sidebar-active-text: {{ $theme['theme_sidebar_active_text'] ?? '#2563eb' }};
    --platform-button-primary-bg: {{ $theme['theme_button_primary_bg'] ?? '#4f46e5' }};
    --platform-button-primary-text: {{ $theme['theme_button_primary_text'] ?? '#ffffff' }};
    --platform-font-body: {{ $font['font_body'] ?? 'Vazirmatn, Tahoma, sans-serif' }};
    --platform-font-title: {{ $font['font_title'] ?? 'Vazirmatn, Tahoma, sans-serif' }};
    --platform-font-size-base: {{ isset($font['font_size_base']) && $font['font_size_base'] !== '' ? $font['font_size_base'] . 'px' : '16px' }};
    --platform-font-size-title: {{ isset($font['font_size_title']) && $font['font_size_title'] !== '' ? $font['font_size_title'] : '1.25' }};
}
body { font-family: var(--platform-font-body); font-size: var(--platform-font-size-base); }
h1, h2, h3, h4, h5, h6, .font-title { font-family: var(--platform-font-title); font-size: calc(1em * var(--platform-font-size-title)); color: var(--platform-title-color); }
.navbar { background: var(--platform-menu-bg) !important; }
.navbar-brand { color: var(--platform-primary) !important; }
.navbar-link { color: var(--platform-menu-text) !important; }
.navbar-link:hover, .navbar-link.text-blue-600 { color: var(--platform-menu-link-active) !important; }
.btn-primary { background: var(--platform-button-primary-bg) !important; color: var(--platform-button-primary-text) !important; }
a { color: var(--platform-link-color); }
a:hover { color: var(--platform-link-hover); }
.sidebar-link { color: var(--platform-sidebar-text); }
.sidebar-link:hover, .sidebar-link.active { background: var(--platform-sidebar-active-bg); color: var(--platform-sidebar-active-text); }
</style>
