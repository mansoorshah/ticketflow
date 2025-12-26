$(document).ready(function () {
    $('#ticketsTable').DataTable({
        pageLength: 20,
        lengthMenu: [10, 20, 50, 100],
        ordering: true,
        searching: true,
        responsive: true,

        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'TicketFlow_Tickets'
            },
            {
                extend: 'pdfHtml5',
                title: 'TicketFlow_Tickets',
                orientation: 'landscape',
                pageSize: 'A4'
            }
        ]
    });
});
