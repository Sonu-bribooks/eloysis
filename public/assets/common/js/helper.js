const Helper = {

    clearErrors(form) {

        $(form)
            .find('.is-invalid')
            .removeClass('is-invalid');

        $(form)
            .find('.invalid-feedback')
            .remove();

    },
    showValidation(errors) {
        console.log('validation error', errors);
        $.each(errors, function (field, messages) {

            // console.log(field, messages);

            let input = $('[name="' + field + '"]');

            input.addClass('is-invalid');

            if (input.next('.invalid-feedback').length === 0) {

                input.after(

                    '<div class="invalid-feedback">' + messages[0] + '</div>'

                );

            }

        });

    },

    loading(button) {

        if (!button || button.length === 0) {

            return;

        }

        button

            .prop('disabled', true)

            .data('html', button.html())

            .html(

                '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...'

            );

    },

    stopLoading(button) {

        if (!button || button.length === 0) {

            return;

        }

        button

            .prop('disabled', false)

            .html(button.data('html'));

    },

    statusSwitch(id, status) {

        return `
            <div class="form-check form-switch">
                <input
                    class="form-check-input btn-status"
                    type="checkbox"
                    data-id="${id}"
                    ${status ? 'checked' : ''}
                >
            </div>
        `;
    }

};

$(document).on(

    'keyup change',

    'input,textarea,select',

    function () {

        $(this)

            .removeClass('is-invalid')

            .next('.invalid-feedback')

            .remove();

    }

);

document.addEventListener('input', function (e) {

    if (e.target.tagName === 'TEXTAREA') {

        const counter = document.querySelector(

            '.textarea-counter[data-target="' + e.target.id + '"]'

        );

        if (counter && e.target.maxLength > 0) {

            counter.innerHTML =
                e.target.value.length + '/' + e.target.maxLength;

        }

    }

});