$(function () {
    $('.check').on('click', function () {
        if ($(this).prop('checked')) {
            // 一旦全てをクリアして再チェックする
            $('.check').prop('checked', false);
            $(this).prop('checked', true);
        }
    });
});
$(function () {
    $('.check_line').on('click', function () {
        if ($(this).prop('checked')) {
            // 一旦全てをクリアして再チェックする
            $('.check_line').prop('checked', false);
            $(this).prop('checked', true);
        }
    });
});
$(function () {
    $('.check_job').on('click', function () {
        if ($(this).prop('checked')) {
            // 一旦全てをクリアして再チェックする
            $('.check_job').prop('checked', false);
            $(this).prop('checked', true);
        }
    });
});
// $(function () {
//     $('.check_kind').on('click', function () {
//         if ($(this).prop('checked')) {
//             // 一旦全てをクリアして再チェックする
//             $('.check_kind').prop('checked', false);
//             $(this).prop('checked', true);
//         }
//     });
// });