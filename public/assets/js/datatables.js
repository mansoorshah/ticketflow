$(document).ready(function () {
    $('#ticketsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50, 100],
        searching: true,
        ordering: true,

        dom: '<"row mb-2"<"col-md-6"B><"col-md-6 text-end"f>>rtip',

        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Excel'
            },
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                orientation: 'landscape',
                pageSize: 'A4'
            }
        ]
    });
});
