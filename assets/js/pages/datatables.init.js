/*
Template Name: Priequity - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Datatables Js File
*/

$(document).ready(function () {
    $('#datatable').DataTable({
        "order": []
    });

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        // lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper');

    $(".dataTables_length select").addClass('form-select form-select-sm');
});