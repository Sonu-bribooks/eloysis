const Classes = {

    init() {
        this.bindEvents();

        this.load();
    },

    bindEvents() {

    },

    load(page = 1) {

        $.ajax({

            url: CLASSES_LIST_URL,
            type: 'GET',
            data: $('#filterForm').serialize() + '&page=' + page,

            success: (response) => {
                console.log(response);

                this.render(response.data);
                // this.renderPagination(response.data);
            },

            error: (e) => {
                Toast.error(e.responseJSON?.message ?? 'Unable to load Academic Classes.');
            }
        })

    },

    render(result) {
        const rows = result.data;

        let html = '';

        if (!rows.length) {

            html = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        No Academic Classes Found
                    </td>
                </tr>
            `;

            $('#classTableBody').html(html);

            return;

        }
    }

}

$(function () {

    Classes.init();

});