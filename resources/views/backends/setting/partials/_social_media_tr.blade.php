<tr class="tr_{{ $key }}">
    <td>
        <input type="text" class="form-control" name="social_media[title][]">
    </td>
    <td class="ps-5">
        <input type="file" class="d-none social_media_icon_input_{{ $key }}" name="social_media[icon][]">
        <img src="{{ asset('uploads/image/default.png') }}" height="auto" width="60px" style="margin-bottom: 6px; cursor:pointer; border:none !important" alt="" class="avatar border social_media_icon social_media_icon_{{ $key }}">
        <input type="hidden" name="social_media[old_icon][]" value="">
    </td>
    <td>
        <input type="text" class="form-control" name="social_media[link][]">
    </td>
    <td>
        <label for="status_{{ $key }}" class="switch" style="padding-left: .75rem">
            <input type="checkbox" class="status" id="status_{{ $key }}"
                data-id="{{ $key }}" checked name="social_media[status_{{ $key }}]">
            <div class="slider">
                <div class="circle">
                    <svg class="cross" xml:space="preserve" style="enable-background:new 0 0 512 512"
                        viewBox="0 0 365.696 365.696" y="0" x="0" height="6" width="6"
                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                        xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path data-original="#000000" fill="currentColor"
                                d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0">
                            </path>
                        </g>
                    </svg>
                    <svg class="checkmark" xml:space="preserve" style="enable-background:new 0 0 512 512"
                        viewBox="0 0 24 24" y="0" x="0" height="10" width="10"
                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                        xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path class="" data-original="#000000" fill="currentColor"
                                d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z">
                            </path>
                        </g>
                    </svg>
                </div>
            </div>
        </label>
    </td>
    <td>
        <a type="button">
            <i class="fa fa-trash-alt text-danger delete_social_media"></i>
        </a>
    </td>
</tr>

<script>
    $('.social_media_icon_{{ $key }}').click(function (e) {
        console.log('social_media_icon_{{ $key }}');
        $('.social_media_icon_input_{{ $key }}').trigger('click');
    });

    $('.social_media_icon_input_{{ $key }}').change(function (e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.social_media_icon_{{ $key }}').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('.delete_social_media').click(function (e) {
        var tbody = $('.tbody');
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
