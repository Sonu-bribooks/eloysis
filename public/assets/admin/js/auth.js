const AdminAuth = {

    init() {
        this.login();
    },

    login() {

        $(document).on('submit', '#loginForm', function (e) {

            e.preventDefault();

            Ajax.request({

                form: this,

                url: $(this).attr('action'),

                method: 'POST',

                success(response) {

                    window.location.href = response.data.redirect;

                }

            });

        });

    }

};

$(function () {
    AdminAuth.init();
});

