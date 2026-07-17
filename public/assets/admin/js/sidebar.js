const Sidebar = {

    init() {

        this.toggle();

    },

    toggle() {

        $('#sidebarToggle').on('click', function () {

            $('body').toggleClass('sidebar-collapse');

        });

    }

};

$(function () {

    Sidebar.init();

});