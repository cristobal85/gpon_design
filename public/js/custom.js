$(document).ready(function () {
    $('table').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "oSearch": {
            "bSmart": false,
            "bRegex": true,
            "sSearch": ""
        }
    });

//  Add and drop multiple entity
    $('.collection-type').collection();
//  Add select2 library to all select fields
    $('select').select2();


    window.onscroll = function () {
        myFunction()
    };

    var navbar = document.getElementById("navbar");
    var sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= 80) {
            navbar.classList.add("fixed-top")
        } else {
            navbar.classList.remove("fixed-top");
        }
    }
});