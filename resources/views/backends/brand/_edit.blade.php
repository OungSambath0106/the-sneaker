@push('css')
@endpush
<div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Update Brand') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form action="{{ route('admin.brand.update', $brand->id) }}" enctype="multipart/form-data"
            class="submit-form" method="post">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                            {{-- @dump($languages) --}}
                            @foreach (json_decode($language, true) as $lang)
                                @if ($lang['status'] == 1)
                                    <li class="nav-item">
                                        <a class="nav-link text-capitalize {{ $lang['code'] == $default_lang ? 'active' : '' }}"
                                            id="lang_{{ $lang['code'] }}-tab" data-toggle="pill"
                                            href="#lang_{{ $lang['code'] }}" role="tab"
                                            aria-controls="lang_{{ $lang['code'] }}"
                                            aria-selected="false">{{ \App\helpers\AppHelper::get_language_name($lang['code']) . '(' . strtoupper($lang['code']) . ')' }}</a>
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent">
                            @foreach (json_decode($language, true) as $lang)
                                @if ($lang['status'] == 1)
                                    <?php
                                    if (count($brand['translations'])) {
                                        $translate = [];
                                        foreach ($brand['translations'] as $t) {
                                            if ($t->locale == $lang['code'] && $t->key == 'name') {
                                                $translate[$lang['code']]['name'] = $t->value;
                                            }
                                            if ($t->locale == $lang['code'] && $t->key == 'description') {
                                                $translate[$lang['code']]['description'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="tab-pane fade {{ $lang['code'] == $default_lang ? 'show active' : '' }}"
                                        id="lang_{{ $lang['code'] }}" role="tabpanel"
                                        aria-labelledby="lang_{{ $lang['code'] }}-tab">
                                        <div class="form-group">
                                            <input type="hidden" name="lang[]" value="{{ $lang['code'] }}">
                                            <label
                                                for="name_{{ $lang['code'] }}">{{ __('Name') }}({{ strtoupper($lang['code']) }})</label>
                                            <input type="text" name="name[]" id="name_{{ $lang['code'] }}"
                                                class="form-control"
                                                value="{{ $translate[$lang['code']]['name'] ?? $brand['name'] }}"
                                                {{ $lang['code'] == 'en' ? 'required' : '' }}>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12 px-0">
                    <div class="form-group">
                        <label for="exampleInputFile">{{ __('Image') }}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="hidden" name="image" class="image_hidden">
                                <input type="file" class="custom-file-input image-file-input" id="exampleInputFile" name="image">
                                <label class="custom-file-label" for="exampleInputFile">{{ $brand->image ? basename($brand->image) : __('Choose file') }}</label>
                            </div>
                        </div>
                        <div class="preview preview-multiple text-center border rounded mt-2" style="height: 150px">
                            <img src="
                            @if ($brand->image && file_exists(public_path('uploads/brand/' . $brand->image)))
                                {{ asset('uploads/brand/' . $brand->image) }}
                            @else
                                {{ asset('uploads/defualt.png') }}
                            @endif"
                                alt="" height="100%">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary submit float-right">{{__('Save')}}</button>
                        {{-- <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">{{ __('Close') }}</button> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

{{-- @push('js') --}}
<script>
    $('.image-file-input').change(function(e) {
        var reader = new FileReader();
        var preview = $(this).closest('.form-group').find('.preview img');
        reader.onload = function(e) {
            preview.attr('src', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
{{-- @endpush --}}
