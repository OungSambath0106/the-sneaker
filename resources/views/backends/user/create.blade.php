@extends('backends.master')
@section('contents')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="border fieldset-table px-3 mb-4 my-3">
                        <legend class="w-auto mb-0 pb-0 title-form text-uppercase">{{ __('Add New User') }}</legend>
                        <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 ">
                                        <label class="required_label">{{__('First Name')}}</label>
                                        <input type="name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}"
                                            name="first_name" placeholder="{{__('Enter First Name')}}">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="required_label">{{__('Last Name')}}</label>
                                        <input type="name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}"
                                            name="last_name" placeholder="{{__('Enter Last Name')}}" >
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group col-md-6">
                                        <label class="required_label">{{__('Username')}}</label>
                                        <input type="name" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}"
                                            name="username" placeholder="{{__('Enter Username')}}" >
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group col-md-6">
                                        <label class="required_label">{{__('Phone Number')}}</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                            name="phone" placeholder="{{__('Enter Phone Number')}}" >
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="required_label">{{__('Telegram Number')}}</label>
                                        <input type="text" class="form-control @error('telegram') is-invalid @enderror" value="{{ old('telegram') }}"
                                            name="telegram" placeholder="{{__('Enter Telegram Number')}}" >
                                        @error('telegram')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="required_label">{{__('Email')}}</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
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
                                        <label class="required_label" for="gender">{{__('Gender')}}</label>
                                        <select class="form-control select2" name="gender">
                                            <option value="male">{{__('Male')}}</option>
                                            <option value="female">{{__('Female')}}</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="required_label" for="role">{{__('Role')}}</label>
                                        <select name="role" id="role" class="form-control select2 @error('password') is-invalid @enderror">
                                            @foreach ($roles as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group col-md-6">
                                        <label>{{__('Address')}}</label>
                                        <input type="text" class="form-control" value="{{ old('address') }}"
                                            name="address" placeholder="{{__('Enter Address')}}" >
                                    </div> --}}

                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">{{__('Image')}}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="hidden" name="image_names" class="image_names_hidden">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="image" accept="image/png, image/jpeg">
                                                    <label class="custom-file-label" for="exampleInputFile">{{ __('Choose file') }}</label>
                                                </div>
                                            </div>
                                            <span class="text-info text-xs">{{ __('Recommend size 512 x 512 px') }}</span>
                                            <div class="preview preview-multiple text-center border rounded mt-2" style="height: 150px">
                                                <img src="{{ asset('uploads/default-profile.png') }}" alt="" height="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <a href="javascript:history.back()" class="text-white btn btn-danger text-decoration-none">
                                            <i class="fas fa-arrow-left"></i>
                                            {{__('Back')}}
                                        </a>
                                    </div>
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i>
                                            {{__('Save')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </fieldset>
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
                var extension = output[0].ext;
                console.log(extension);
                var files = Compress.convertBase64ToFile(output[0].data, output[0].ext);
                var formData = new FormData();

                var image_names_hidden = $(this).closest('.custom-file').find('input[type=hidden]');
                var container = $(this).closest('.form-group').find('.preview');
                if (container.find('img').attr('src') === `{{ asset('uploads/default-profile.png') }}`) {
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
                            var img = $('<img>').attr('src', "{{ asset('uploads/temp') }}" +'/'+ temp_file);
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
    </script>
@endpush
