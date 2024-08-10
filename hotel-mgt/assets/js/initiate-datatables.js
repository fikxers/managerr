// Initiate datatables in roles, tables, users page
(function() {
    'use strict';
    
    $('#dataTables-example').DataTable({
        responsive: true,
        pageLength: 20,
        lengthChange: false,
        searching: true,
        ordering: true
    });

    $('#dataTables-example2').DataTable({
        responsive: true,
        pageLength: 20,
        lengthChange: false,
        searching: true,
        ordering: true
    });

    $('.responsive-tbl').DataTable({
        responsive: true,
        pageLength: 20,
        lengthChange: false,
        searching: true,
        ordering: true
    });
})();

// $(document).ready( function () {
//     $('.responsive-tbl').DataTable();
// } );