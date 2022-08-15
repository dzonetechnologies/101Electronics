$(document).ready(function () {
    'use strict';

    $('.repeater-default').repeater();

    $('.repeater-custom-show-hide').repeater({
        show: function () {
            $(this).slideDown();
            let Select2 = $(".select2");
            if(Select2.length > 0){
                Select2.select2();
            }
        },
        hide: function (remove) {
            $(this).slideUp(remove);
            // if (confirm('Are you sure you want to remove this item?')) {
            //     $(this).slideUp(remove);
            // }
        }
    });
});
