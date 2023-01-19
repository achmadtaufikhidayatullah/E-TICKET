@extends('frontEnd.layout.tamplate')


@section('content')
<div class="container">
    <div class="card w-75 m-auto shadow p-4 card-100-mobile">
        <div class="text-center">
            <h1>Registration Form</h3>
        </div>
        <div class="card-body mt-3">
            <form action="{{ route('regist.store') }}" method="POST">
               @csrf
                <div class="mb-4">
                    <label for="id-card" class="form-label">
                        <small>No. KTP</small><br>
                        <small class="text-muted"><em>ID Card Number</em></small>
                    </label>
                    <input type="number" class="form-control" id="id-card" placeholder="Ex: 5171xxxxxxxxxxxx" name="no_ktp" value="{{ old('no_ktp') }}" required>
                </div>

                <div class="mb-4">
                    <label for="Nama" class="form-label">
                        <small>Nama Lengkap</small><br>
                        <small class="text-muted"><em>Full Name</em></small>
                    </label>
                    <input type="text" class="form-control" id="name" placeholder="Your full name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="form-label">
                        <small>Nomor Handphone</small><br>
                        <small class="text-muted"><em>Phone Number</em></small>
                    </label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="Your Phone Number ex: 081xxxxxxxxx"
                        required>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">
                        <small>ALamat Email</small><br>
                        <small class="text-muted"><em>Email Address</em></small>
                    </label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Your Email ex: customer@gmail.com"
                        required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        <small>Kata Sandi</small><br>
                        <small class="text-muted"><em>Password</em></small>
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Input your Password for login"
                            aria-label="Input your Password for login" aria-describedby="basic-addon2" id="password" name="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="btn-pass"><i
                                class="fa-regular fa-eye" id="btn-eye-pass"></i></button>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="confirmation-password" class="form-label">
                        <small>Konfirmasi Kata Sandi</small><br>
                        <small class="text-muted"><em>Password Confirmation</em></small>
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Reinput Your Password here"
                            aria-label="Input your Password for login" aria-describedby="basic-addon2"
                            id="confirmation-password" name="confirm_password" required>
                        <button class="btn btn-outline-secondary" type="button" id="btn-confirmation-pass"><i
                                class="fa-regular fa-eye" id="btn-eye-confirmation-pass"></i></button>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary btn-lg">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('bottom')
<script>
    // document.getElementById("id-card").placeholder = "Ex: 517104xxxxxx";
    $('#btn-pass').on('click', function () {
        var className = $('#btn-eye-pass').attr('class');

        // console.log(className);
        if (className == 'fa-regular fa-eye') {
            $('#btn-eye-pass').removeClass('fa-regular fa-eye');
            $('#btn-eye-pass').addClass('fa-regular fa-eye-slash');

            $('#password').attr('type', 'text');
        }

        if (className == 'fa-regular fa-eye-slash') {
            $('#btn-eye-pass').removeClass('fa-regular fa-eye-slash');
            $('#btn-eye-pass').addClass('fa-regular fa-eye');

            $('#password').attr('type', 'password');
        }
    });

    $('#btn-confirmation-pass').on('click', function () {
        var className = $('#btn-eye-confirmation-pass').attr('class');

        // console.log(className);
        if (className == 'fa-regular fa-eye') {
            $('#btn-eye-confirmation-pass').removeClass('fa-regular fa-eye');
            $('#btn-eye-confirmation-pass').addClass('fa-regular fa-eye-slash');

            $('#confirmation-password').attr('type', 'text');
        }

        if (className == 'fa-regular fa-eye-slash') {
            $('#btn-eye-confirmation-pass').removeClass('fa-regular fa-eye-slash');
            $('#btn-eye-confirmation-pass').addClass('fa-regular fa-eye');

            $('#confirmation-password').attr('type', 'password');
        }
    });

</script>
@endpush


@endsection
