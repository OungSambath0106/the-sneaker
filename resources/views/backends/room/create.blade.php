@extends('backends.master')
@section('contents')
    <!-- Content Wrapper. Contains page content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Add New Room') }}</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.room.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                            {{-- @dump($language) --}}
                                            @foreach (json_decode($language, true) as $lang)
                                                @if ($lang['status'] == 1)
                                                    <li class="nav-item">
                                                        <a class="nav-link text-capitalize {{ $lang['code'] == $default_lang ? 'active' : '' }}"
                                                            id="lang_{{ $lang['code'] }}-tab" data-toggle="pill"
                                                            href="#lang_{{ $lang['code'] }}" data-lang="{{ $lang['code'] }}"
                                                            role="tab" aria-controls="lang_{{ $lang['code'] }}"
                                                            aria-selected="false">{{ \App\helpers\AppHelper::get_language_name($lang['name']) . '(' . strtoupper($lang['code']) . ')' }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="custom-content-below-tabContent">
                                            @foreach (json_decode($language, true) as $key => $lang)
                                                @if ($lang['status'] == 1)
                                                    <div class="tab-pane fade {{ $lang['code'] == $default_lang ? 'show active' : '' }} mt-3"
                                                        id="lang_{{ $lang['code'] }}" role="tabpanel"
                                                        aria-labelledby="lang_{{ $lang['code'] }}-tab">
                                                        <div class="form-group">
                                                            <input type="hidden" name="lang[]"
                                                                value="{{ $lang['code'] }}">
                                                            <label class="required_label"
                                                                for="title_{{ $lang['code'] }}">{{ __('Title') }}({{ strtoupper($lang['code']) }})</label>
                                                            <input type="title" id="title_{{ $lang['code'] }}"
                                                                class="form-control @error('title') is-invalid @enderror"
                                                                name="title[]" placeholder="{{ __('Enter Title') }}"
                                                                value="">
                                                            @error('title')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group" hidden>
                                                            <label class="required_label"
                                                                for="special_note_{{ $lang['code'] }}">{{ __('Special Check-In Instruction') }}({{ strtoupper($lang['code']) }})</label>
                                                            <input type="special_note"
                                                                id="special_note_{{ $lang['code'] }}"
                                                                class="form-control @error('special_note') is-invalid @enderror"
                                                                name="special_note[]"
                                                                placeholder="{{ __('Enter Special Check-In Instruction') }}"
                                                                value="">
                                                            @error('special_note')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="checkin">{{ __('Checkin') }}</label>
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>{{ __('Title') }}</th>
                                                                            <th>
                                                                                <button type="button"
                                                                                    class="btn btn-success btn-sm btn_add_row_checkin"
                                                                                    data-lang="{{ $lang['code'] }}">
                                                                                    <i class="fa fa-plus-circle"></i>
                                                                                </button>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    @include('backends.room.room_checkin_detail_tbody')
                                                                </table>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="checkin">{{ __('Checkout') }}</label>
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>{{ __('Title') }}</th>
                                                                            <th>
                                                                                <button type="button"
                                                                                    class="btn btn-success btn-sm btn_add_row_checkout"
                                                                                    data-lang="{{ $lang['code'] }}">
                                                                                    <i class="fa fa-plus-circle"></i>
                                                                                </button>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    @include('backends.room.room_checkout_detail_tbody')
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="required_label"
                                                                for="description_{{ $lang['code'] }}">{{ __('Description') }}({{ strtoupper($lang['code']) }})</label>
                                                            <textarea id="description_{{ $lang['code'] }}"
                                                                class="form-control summernote @error('description') is-invalid @enderror" name="description[]"
                                                                placeholder="{{ __('Enter Description') }}" rows="4"></textarea>
                                                            @error('description')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <!-- <div class="row">
                                                            <div class="form-group col-md-4 col-12">
                                                                <label for="column_1_{{ $lang['code'] }}">{{ __('Column1') }}({{ strtoupper($lang['code']) }})</label>
                                                                <textarea id="column_1_{{ $lang['code'] }}"
                                                                        class="form-control summernote @error('column_1') is-invalid @enderror" name="column_1[]"
                                                                        placeholder="{{ __('Type Something') }}" rows="4"></textarea>
                                                                    @error('column_1')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                            </div>
                                                            <div class="form-group col-md-4 col-12">
                                                                <label for="column_2_{{ $lang['code'] }}">{{ __('Column2') }}({{ strtoupper($lang['code']) }})</label>
                                                                <textarea id="column_2_{{ $lang['code'] }}"
                                                                    class="form-control summernote @error('column_2') is-invalid @enderror" name="column_2[]"
                                                                    placeholder="{{ __('Type Something') }}" rows="4"></textarea>
                                                                @error('column_2')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-4 col-12">
                                                                <label for="column_3_{{ $lang['code'] }}">{{ __('Column3') }}({{ strtoupper($lang['code']) }})</label>
                                                                <textarea id="column_3_{{ $lang['code'] }}"
                                                                    class="form-control summernote @error('column_3') is-invalid @enderror" name="column_3[]"
                                                                    placeholder="{{ __('Type Something') }}" rows="4"></textarea>
                                                                @error('column_1')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card no_translate_wrapper">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('General Info') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="number">{{ __('Number') }}</label>
                                        <input type="number" class="form-control @error('number') is-invalid @enderror"
                                            value="{{ old('number') }}" name="number"
                                            placeholder="{{ __('Enter number of room') }}" min="0" step="1">
                                        @error('number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="adult">{{ __('Adult') }}</label>
                                        <input type="number" class="form-control @error('adult') is-invalid @enderror"
                                            value="{{ old('adult') }}" name="adult"
                                            placeholder="{{ __('Enter total adult') }}" min="0" step="1">
                                        @error('adult')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="child">{{ __('Child') }}</label>
                                        <input type="number" class="form-control @error('child') is-invalid @enderror"
                                            value="{{ old('child') }}" name="child"
                                            placeholder="{{ __('Enter total child') }}" min="0" step="1">
                                        @error('child')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="price">{{ __('Price') }}</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price') }}" name="price"
                                            placeholder="{{ __('Enter total price') }}" min="0" step="1">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- <div class="form-group col-md-6">
                                        <label for="video">{{ __('Video') }}</label>
                                        <input type="text" class="form-control @error('video') is-invalid @enderror"
                                            value="{{ old('video') }}" name="video"
                                            placeholder="{{ __('Enter youtube video link') }}">
                                        @error('video')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="room_thumbnail">{{ __('Room Thumbnail') }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="hidden" name="room_thumbnail_names"
                                                        class="room_thumbnail_names_hidden">
                                                    <input type="file" class="custom-file-input_room_thumbnail"
                                                        id="room_thumbnail" name="image"
                                                        accept="image/png, image/jpeg">
                                                    <label class="custom-file-label"
                                                        for="room_thumbnail">{{ __('Choose file') }}</label>
                                                </div>
                                            </div>
                                            {{-- <span class="text-info text-xs">{{ __('Recommend size 512 x 512 px') }}</span> --}}
                                            <div class="preview preview-multiple text-center border rounded mt-2"
                                                style="height: 150px">
                                                <img src="{{ asset('uploads/image/default.png') }}" alt=""
                                                    height="100%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="video_thumbnail">{{ __('Video Thumbnail') }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="hidden" name="video_thumbnail_names"
                                                        class="video_thumbnail_names_hidden">
                                                    <input type="file" class="custom-file-input_video_thumbnail"
                                                        id="video_thumbnail" name="image"
                                                        accept="image/png, image/jpeg">
                                                    <label class="custom-file-label"
                                                        for="video_thumbnail">{{ __('Choose file') }}</label>
                                                </div>
                                            </div>
                                            {{-- <span class="text-info text-xs">{{ __('Recommend size 512 x 512 px') }}</span> --}}
                                            <div class="preview preview-multiple text-center border rounded mt-2"
                                                style="height: 150px">
                                                <img src="{{ asset('uploads/image/default.png') }}" alt=""
                                                    height="100%">
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="form-group col-12">
                                        <div class="form-group">
                                            <label for="exampleInputFile">{{ __('Gallery') }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="hidden" name="image_names" class="image_names_hidden">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile"
                                                        name="gallery[]" multiple accept="image/png, image/jpeg">
                                                    <label class="custom-file-label"
                                                        for="exampleInputFile">{{ __('Choose file') }}</label>
                                                </div>
                                            </div>
                                            <div class="preview preview-multiple text-center border rounded mt-2"
                                                style="height: 300px">
                                                <img src="{{ asset('uploads/image/default.png') }}" alt=""
                                                    height="100%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">{{ __('Amenities') }}</label>
                                        <div class="row">
                                            @if ($amenities->value)
                                                @foreach ($amenities->value as $row)
                                                    <div class="col-12 col-md-3 mt-2">
                                                        <div class="icheck-primary d-inline col-md-2 align-content-center">
                                                            <input type="checkbox"
                                                                id="checkboxPrimary2{{ $loop->index }}"
                                                                name="amenities[]" value="{{ json_encode($row) }}">
                                                            <label for="checkboxPrimary2{{ $loop->index }}">
                                                                {{ $row['title'] }}
                                                            </label>
                                                        </div>
                                                        <img src="@if ($row['image'] && file_exists(public_path('uploads/amenity/' . $row['image']))){{ asset('uploads/amenity/' . $row['image']) }}
                                                            @else {{ asset('uploads/image/default.png') }} @endif"
                                                            alt="Image" style="width: 23px; height: 23px">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12" hidden>
                                        <div class="form-group">
                                            <label for="pet">{{ __('Pet') }}</label>
                                            <div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="pet" name="pet"
                                                        {{ old('pet') ? 'checked' : '' }}>
                                                    <label for="pet">
                                                        {{ __('Allow') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <button type="submit" class="btn btn-primary float-right">
                                    <i class="fa fa-save"></i>
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <script>
        const compressor = new window.Compress();
        $('.custom-file-input_room_thumbnail').change(function(e) {
            compressor.compress([...e.target.files], {
                size: 4,
                quality: 0.75,
            }).then((output) => {
                var files = Compress.convertBase64ToFile(output[0].data, output[0].ext);
                var formData = new FormData();

                var image_names_hidden = $(this).closest('.custom-file').find('input[type=hidden]');
                var container = $(this).closest('.form-group').find('.preview');
                if (container.find('img').attr('src') === `{{ asset('uploads/image/default.png') }}`) {
                    container.empty();
                }
                formData.append('image', files);

                $.ajax({
                    url: "{{ route('save_temp_file') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 0) {
                            toastr.error(response.msg);
                        }
                        if (response.status == 1) {
                            container.empty();
                            var temp_file = response.temp_files;
                            var img_container = $('<div></div>').addClass('img_container');
                            var img = $('<img>').attr('src', "{{ asset('uploads/temp') }}" +
                                '/' + temp_file);
                            img_container.append(img);
                            container.append(img_container);

                            var new_file_name = temp_file;
                            console.log(new_file_name);

                            image_names_hidden.val(new_file_name);
                        }
                    }
                });
            });
        });

        $('.custom-file-input_video_thumbnail').change(function(e) {
            compressor.compress([...e.target.files], {
                size: 4,
                quality: 0.75,
            }).then((output) => {
                var files = Compress.convertBase64ToFile(output[0].data, output[0].ext);
                var formData = new FormData();

                var image_names_hidden = $(this).closest('.custom-file').find('input[type=hidden]');
                var container = $(this).closest('.form-group').find('.preview');
                if (container.find('img').attr('src') === `{{ asset('uploads/image/default.png') }}`) {
                    container.empty();
                }
                formData.append('image', files);

                $.ajax({
                    url: "{{ route('save_temp_file') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 0) {
                            toastr.error(response.msg);
                        }
                        if (response.status == 1) {
                            container.empty();
                            var temp_file = response.temp_files;
                            var img_container = $('<div></div>').addClass('img_container');
                            var img = $('<img>').attr('src', "{{ asset('uploads/temp') }}" +
                                '/' + temp_file);
                            img_container.append(img);
                            container.append(img_container);

                            var new_file_name = temp_file;
                            console.log(new_file_name);

                            image_names_hidden.val(new_file_name);
                        }
                    }
                });
            });
        });

        $('.custom-file-input').change(function(e) {
            compressor.compress([...e.target.files], {
                size: 4,
                quality: 0.75,
            }).then((output) => {

                var image_names_hidden = $(this).closest('.custom-file').find('input[type=hidden]');
                var container = $(this).closest('.form-group').find('.preview');
                if (container.find('img').attr('src') === `{{ asset('uploads/image/default.png') }}`) {
                    container.empty();
                }

                var file = '';
                var formData = new FormData();
                $.each(output, function(index, value) {
                    file = Compress.convertBase64ToFile(value.data, value.ext);
                    formData.append('image[]', file);
                });
                $.ajax({
                    url: "{{ route('save_temp_file') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == 0) {
                            toastr.error(response.msg);
                        }
                        if (response.status == 1) {
                            var temp_files = response.temp_files;
                            for (var i = 0; i < temp_files.length; i++) {
                                var temp_file = temp_files[i];
                                var img_container = $('<div></div>').addClass('img_container');
                                // var remove_img = '<a href="#" class="remove_image"><i class="fa fa-times" data-img_name="'+ temp_files[i] +'"></i></a>';
                                // var remove_img = $('<i></i>').attr('data-img_name', temp_files[i]).addClass('fa fa-times remove_image');
                                var img = $('<img>').attr('src',
                                    "{{ asset('uploads/temp') }}" + '/' + temp_file);
                                img_container.append(img);
                                // img_container.append(remove_img);
                                container.append(img_container);

                                var curent_file_name = image_names_hidden.val();
                                var new_file_name = curent_file_name + ' ' + temp_file;
                                console.log(new_file_name);

                                image_names_hidden.val(new_file_name);
                            }
                        }
                    }
                });
            });
        });
        $(document).on('click', '.nav-tabs .nav-link', function(e) {
            if ($(this).data('lang') != 'en') {
                $('.no_translate_wrapper').addClass('d-none');
            } else {
                $('.no_translate_wrapper').removeClass('d-none');
            }
        });
        $('.btn_add_row_checkin').click(function(e) {
            var lang = $(this).data('lang');
            var tbody = $(`.product_detail_tbody_${lang}`);
            var numRows = tbody.find("tr").length;
            console.log(numRows);
            $.ajax({
                type: "get",
                url: window.location.href,
                data: {
                    "type": "checkin",
                    "lang": lang,
                    "key": numRows
                },
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    $(tbody).append(response.tr);
                }
            });
        });
        $('.btn_add_row_checkout').click(function(e) {
            var lang = $(this).data('lang');
            var tbody = $(`.room_checkout_tbody_${lang}`);
            var numRows = tbody.find("tr").length;
            console.log(numRows);
            $.ajax({
                type: "get",
                url: window.location.href,
                data: {
                    "type": "checkout",
                    "lang": lang,
                    "key": numRows
                },
                dataType: "json",
                success: function(response) {
                    $(tbody).append(response.tr);
                }
            });
        });

        $(document).on('click', 'button[type=submit]', function(e) {
            e.preventDefault();
            // alert('okk');
            $('input[type=file]').attr('disabled', true);
            $(this).closest('form').submit();
        });
    </script>
@endpush