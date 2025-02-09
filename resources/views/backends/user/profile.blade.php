@extends('backends.master')
@section('contents')
    <!-- Content Wrapper. Contains page content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('Profile')}}</h1>
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
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <form method="POST" action="{{ route('admin.update_info', auth()->user()->id) }}" enctype="multipart/form-data">
                                @csrf
                                {{-- @method('PUT') --}}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 ">
                                            <label class="required_label">{{__('First Name')}}</label>
                                            <input type="name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', auth()->user()->first_name) }}"
                                                name="first_name" placeholder="{{__('Enter First Name')}}">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="required_label">{{__('Last Name')}}</label>
                                            <input type="name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', auth()->user()->last_name) }}"
                                                name="last_name" placeholder="{{__('Enter Last Name')}}" >
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="required_label">{{__('Username')}}</label>
                                            <input type="name" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', auth()->user()->name) }}"
                                                name="username" placeholder="{{__('Enter Username')}}" >
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="required_label">{{__('Phone Number')}}</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', auth()->user()->phone) }}"
                                                name="phone" placeholder="{{__('Enter Phone Number')}}" >
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="required_label">{{__('Telegram Number')}}</label>
                                            <input type="text" class="form-control @error('telegram') is-invalid @enderror" value="{{ old('telegram', auth()->user()->telegram) }}"
                                                name="telegram" placeholder="{{__('Enter Telegram Number')}}" >
                                            @error('telegram')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="required_label">{{__('Email')}}</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}"
                                                name="email" placeholder="{{__('Enter Email')}}" >
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="required_label">{{__('Password')}}</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" value=""
                                                name="password" placeholder="{{__('Enter Password')}}" >
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{-- <div class="form-group">
                                                <label for="exampleInputFile">{{__('Image')}}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                                        <label class="custom-file-label" for="exampleInputFile">{{ auth()->user()->image ?? __('Choose file') }}</label>
                                                    </div>
                                                </div>
                                                <div class="preview text-center border rounded mt-2" style="height: 150px">
                                                    <img src="
                                                    @if (auth()->user()->image && file_exists(public_path('uploads/users/' . auth()->user()->image)))
                                                        {{ asset('uploads/users/'. auth()->user()->image) }}
                                                    @else
                                                        {{ asset('uploads/default-profile.png') }}
                                                    @endif
                                                    " alt="" height="100%">
                                                </div>
                                            </div> --}}
                                            <div class="form-group">
                                                <label for="exampleInputFile">{{__('Image')}}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="hidden" name="image_names" class="image_names_hidden">
                                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image" accept="image/png, image/jpeg">
                                                        <label class="custom-file-label" for="exampleInputFile">{{ auth()->user()->image ?? __('Choose file') }}</label>
                                                    </div>
                                                </div>
                                                <span class="text-info text-xs">{{ __('Recommend size 512 x 512 px') }}</span>
                                                <div class="preview preview-multiple text-center border rounded mt-2" style="height: 150px">
                                                    <div class="update_image">
                                                        <div class="img_container">
                                                            <img src="
                                                            @if (auth()->user()->image && file_exists(public_path('uploads/users/' . auth()->user()->image)))
                                                                {{ asset('uploads/users/'. auth()->user()->image) }}
                                                            @else
                                                                {{ asset('uploads/default-profile.png') }}
                                                            @endif
                                                            " alt="" height="100%">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
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
        $('.custom-file-input').change(function (e) {
            compressor.compress([...e.target.files], {
                size: 4,
                quality: 0.75,
            }).then((output) => {
                var files = Compress.convertBase64ToFile(output[0].data, output[0].ext);
                var formData = new FormData();

                var image_names_hidden = $(this).closest('.custom-file').find('input[type=hidden]');
                var container = $(this).closest('.form-group').find('.preview');
                container.find('.update_image').empty();
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
                            var temp_files = response.temp_files;
                            for (var i = 0; i < temp_files.length; i++) {
                                var temp_file = temp_files[i];
                                var img_container = $('<div></div>').addClass('img_container');
                                var img = $('<img>').attr('src', "{{ asset('uploads/temp') }}" +'/'+ temp_file);
                                img_container.append(img);
                                container.append(img_container);
                                // $(selector).replaceWith(newContent);

                                var new_file_name = temp_file;
                                console.log(new_file_name);

                                image_names_hidden.val(new_file_name);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endpush
