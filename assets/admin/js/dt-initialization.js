$(document).ready(function() {
    $('#abscenceTable').DataTable( {
        dom: 'Blfrtip',
        buttons: [
            {
                extend : 'pdfHtml5',
                title : "Pullit Coaches Abscence",
           },
            {
                extend : 'excel',
                title : "Pullit Coaches Abscence",
            },
            {
                extend : 'csv',
                title : "Pullit Coaches Abscence",
            },
            {
                extend : 'copy',
                title : "Pullit Coaches Abscence",
            },
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]  
    });
});
