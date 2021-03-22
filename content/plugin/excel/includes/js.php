<?php
switch ($path[2]) {
    case 'view':
        ?>
        //<script>
        $(document).ready(function(){
            $("#btnExport").click(function() {
                let table = document.querySelector("#data");
                TableToExcel.convert(table);
            });
        });
        <?php
        break;
    default:

        break;
}