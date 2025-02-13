<tr class="payment_{{ $key }}">
    <td>
        <input type="text" class="form-control" name="payment[title][]">
    </td>
    <td>
        <input type="file" class="d-none payment_icon_input_{{ $key }}" name="payment[icon][]">
        <img src="{{ asset('uploads/image/default.png') }}" height="auto" width="60px" style="margin-bottom: 6px; cursor:pointer; border:none !important" alt="" class="avatar border payment_icon payment_icon_{{ $key }}">

        <input type="hidden" name="payment[old_icon][]" value="">
    </td>
    <td>
        <div class="ckbx-style-9 mt-2">
            <input type="checkbox" class="status" id="{{ $key }}" data-id="{{ $key }}" checked name="payment[status_{{ $key }}]">
            <label for="{{ $key }}"></label>
        </div>
    </td>
    <td>
        <a type="button">
            <i class="fa fa-trash-alt text-danger delete_payment"></i>
        </a>
    </td>
</tr>

<script>
    $('.payment_icon_{{ $key }}').click(function (e) {
        console.log('payment_icon_{{ $key }}');
        $('.payment_icon_input_{{ $key }}').trigger('click');
    });

    $('.payment_icon_input_{{ $key }}').change(function (e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.payment_icon_{{ $key }}').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('.delete_payment').click(function (e) {
        var tbody = $('.payment_tbody');
        var numRows = tbody.find("tr").length;
        if (numRows == 1) {
            toastr.error('{{ __('Cannot remove all row') }}');
            return;
        } else if (numRows >= 2) {
            $(this).closest('tr').remove();
        }
    });
</script>

@push('js')

@endpush
