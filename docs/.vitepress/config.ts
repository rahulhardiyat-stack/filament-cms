import { defineConfig } from 'vitepress'

export default defineConfig({
    title: 'Dokumentasi Filament CMS',
    description: 'Panduan dashboard admin CMS blog berbasis Filament v3',
    lang: 'id-ID',
    base: '/docs/',
    themeConfig: {
        nav: [
            { text: '🏠 Mulai', link: '/' },
            { text: '🧭 Struktur', link: '/filament/struktur' },
            { text: '🛠️ Customisasi', link: '/customisasi/cheatsheet' },
        ],
        sidebar: [
            {
                text: '🏠 Pengantar',
                items: [
                    { text: '👋 Mulai', link: '/' },
                    { text: '🗺️ Peta File', link: '/peta-file' },
                ],
            },
            {
                text: '🧭 Bab 1: Struktur Filament',
                items: [
                    { text: '🚪 Panel Admin', link: '/filament/panel-admin' },
                    { text: '📦 Resource & Pages', link: '/filament/struktur' },
                    { text: '🧩 Widget Dashboard', link: '/filament/widget-dashboard' },
                ],
            },
            {
                text: '📝 Bab 2: Form Create/Edit',
                items: [
                    { text: '🏗️ Layout Grid & Section', link: '/form/layout-grid' },
                    { text: '✏️ Field Input', link: '/form/field-input' },
                    { text: '🔗 Relationship Select', link: '/form/relationship-select' },
                ],
            },
            {
                text: '📊 Bab 3: Table List Data',
                items: [
                    { text: '📋 Columns', link: '/table/columns' },
                    { text: '🔎 Search Sort Filter', link: '/table/search-sort-filter' },
                    { text: '⚡ Actions & Bulk Actions', link: '/table/actions' },
                ],
            },
            {
                text: '🛠️ Bab 4: Customisasi Cepat',
                items: [
                    { text: '🎯 Cheatsheet Edit', link: '/customisasi/cheatsheet' },
                    { text: '🏷️ Label & Teks', link: '/customisasi/label-teks' },
                    { text: '🎨 Icon Warna Menu', link: '/customisasi/icon-warna-menu' },
                    { text: '🧱 Form Lengkap', link: '/customisasi/form-lengkap' },
                    { text: '📊 Table Lengkap', link: '/customisasi/table-lengkap' },
                    { text: '🔘 Button & Modal', link: '/customisasi/button-modal' },
                    { text: '🧩 Widget & Dashboard', link: '/customisasi/widget-dashboard' },
                    { text: '🔐 Akses & Permission', link: '/customisasi/akses-permission' },
                ],
            },
        ],
        search: {
            provider: 'local',
        },
    },
})
