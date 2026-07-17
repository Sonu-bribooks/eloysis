const Toast = {

    success(message) {

        Swal.fire({

            toast: true,

            position: 'top-end',

            icon: 'success',

            title: message,

            showConfirmButton: false,

            timer: 3000

        });

    },

    error(message) {

        Swal.fire({

            toast: true,

            position: 'top-end',

            icon: 'error',

            title: message,

            showConfirmButton: false,

            timer: 3000

        });

    }

}