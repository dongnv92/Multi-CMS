<?php
switch ($path[2]){
    default:
        ?>
        //<script>
        $(document).ready(function () {
            var countries = [
                { value: 'Vietnam', data: 'Vietnam' },
                { value: 'Campuchia', data: 'Campuchia' },
                { value: 'Lao', data: 'Lao' },
                { value: 'Thailan', data: 'Thailan' },
                { value: 'China', data: 'China' },
                { value: 'English', data: 'English' }
            ];

            $('#autocomplete').autocomplete({
                lookup: countries,
                onSelect: function (suggestion) {
                    alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
                }
            });
        });
        <?php
        break;
}