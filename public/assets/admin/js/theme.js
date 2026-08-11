const Theme = {

    storageKey: 'admin_theme',


    init() {

        const savedTheme =
            localStorage.getItem(
                this.storageKey
            );


        const theme =
            savedTheme || 'light';


        this.apply(theme);


        this.bindEvents();

    },


    bindEvents() {

        $(document).on(
            'click',
            '#themeToggle',
            () => {

                this.toggle();

            }
        );

    },


    toggle() {

        const current =
            document.documentElement
                .getAttribute('data-theme') || 'light';


        const newTheme =
            current === 'dark'
                ? 'light'
                : 'dark';


        this.apply(newTheme);

    },


    apply(theme) {

        document.documentElement
            .setAttribute(
                'data-theme',
                theme
            );


        localStorage.setItem(
            this.storageKey,
            theme
        );


        this.updateIcon(theme);

    },


    updateIcon(theme) {

        const icon =
            $('#themeToggleIcon');


        if (!icon.length) {

            return;

        }


        if (theme === 'dark') {

            icon
                .removeClass('bi-moon-stars')
                .addClass('bi-sun');

        } else {

            icon
                .removeClass('bi-sun')
                .addClass('bi-moon-stars');

        }

    }

};


$(function () {

    Theme.init();

});