const Form = {

    init() {

        this.contact();

    },

    contact() {

        $(document).on('submit', '#contactForm', function (e) {

            e.preventDefault();
            // alert($(this).attr('action'));
            Ajax.request({

                form: this,

                url: $(this).attr('action'),

                method: 'POST',

                success(response) {

                    $('#contactForm')[0].reset();

                }

            });

        });

    }

};