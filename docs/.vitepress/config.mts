import {defineConfig} from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel LangCountry",
    description: "The localisation package for auto date-formats, language switcher helper and more.",
    lastUpdated: true,
    base: '/laravel-lang-country',
    themeConfig: {
        logo: 'logo.svg',
        nav: [
            {
                text: 'Version 4 (current)',
                items: [
                    {
                        text: 'Version 3',
                        link: 'https://stefro.github.io/laravel-lang-country-docs-v3/'
                    }
                ]
            },
        ],

        sidebar: [
            {
                text: '<div class="tip custom-block"><p style="margin-bottom: 5px; font-weight: bold">Version 4.x ⭐️</p></div>',
            },
            {
                text: 'Getting Started',
                collapsed: false,
                items: [
                    {text: 'Introduction', link: '/'},
                    {text: 'Installation', link: '/getting-started/installation'},
                    {text: 'Change log', link: '/getting-started/changelog'},
                    {text: 'Upgrade guide', link: '/getting-started/upgrade'},
                ]
            }, {
                text: 'Usage',
                collapsed: false,
                items: [
                    {text: 'Configuration', link: '/usage/configuration'},
                    {text: 'Language switcher', link: '/usage/language-switcher'},
                    {text: 'Middleware', link: '/usage/middleware'},
                    {text: 'Date/time helpers', link: '/usage/date-time'},
                    {text: 'Language helpers', link: '/usage/language'},
                    {text: 'Currency helpers', link: '/usage/currency'},
                    {text: 'Overrides', link: '/usage/override'},
                ]
            }, {
                text: 'Contribute',
                collapsed: true,
                items: [
                    {text: 'How can you help?', link: 'contribute/country-info'},
                    {text: 'Contribution', link: 'contribute/contribution'}
                ]
            }
        ],

        socialLinks: [
            {icon: 'github', link: 'https://github.com/stefro/laravel-lang-country'}
        ],
        search: {
            provider: 'local'
        }
    },
    head: [
        [
            'script',
            {async: '', src: 'https://www.googletagmanager.com/gtag/js?id=G-ZNPSG44PGL'}
        ],
        [
            'script',
            {},
            `window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-ZNPSG44PGL');`
        ]
    ]
})
