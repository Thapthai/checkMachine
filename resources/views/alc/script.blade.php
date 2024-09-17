<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
    $(function() {

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' | ' + picker.endDate.format(
                'YYYY-MM-DD'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var maxFields = 10; // Maximum number of input fields for uploading images

        $('.add_button').click(function() {
            var wrapperId = '.field_wrapper_' + $(this).data('id');
            var fieldCount = $(wrapperId + ' input[type="file"]').length;

            if (fieldCount < maxFields) {
                var newFieldHTML = '<div><input type="file" name="images[' + fieldCount +
                    ']" accept="image/*"/><a href="javascript:void(0);" class="remove_button">ลบ</a></div>';
                $(wrapperId).append(newFieldHTML);
            }
        });

        $(document).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
    });
</script>
