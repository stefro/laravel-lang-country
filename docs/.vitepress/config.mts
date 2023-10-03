import {defineConfig} from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel LangCountry",
    description: "The localisation package for auto date-formats, language switcher helper and more.",
    lastUpdated: true,
    base: '/laravel-lang-country',
    themeConfig: {
        logo: '/public/logo.svg',
        nav: [
            {text: 'Home', link: '/'},
        ],

        sidebar: [
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
            {async: '', src: 'https://www.googletagmanager.com/gtag/js?id=GTM-K3B7S4ZH'}
        ],
        [
            'script',
            {},
            `window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'GTM-K3B7S4ZH');`
        ]
    ]
})
