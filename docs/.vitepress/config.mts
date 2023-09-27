import {defineConfig} from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel LangCountry",
    description: "The localisation package for auto date-formats, language switcher helper and more.",
    lastUpdated: true,
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
                    {text: 'Language helpers', link: '/usage/language'},
                    {text: 'Date/time helpers', link: '/usage/date-time'},
                    {text: 'Overrides', link: '/usage/override'},
                ]
            }
        ],

        socialLinks: [
            {icon: 'github', link: 'https://github.com/stefro/laravel-lang-country'}
        ],
        search: {
            provider: 'local'
        }
    }
})
