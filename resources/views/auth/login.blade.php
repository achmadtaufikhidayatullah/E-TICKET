@extends('frontEnd.layout.tamplate')


@section('content')
<div class="container">
    <div class="card w-50 m-auto shadow p-4 card-100-mobile">
        <div class="text-center">
            <h1>Login</h3>
        </div>
        <div class="card-body mt-3">
            <form action="{{ route('login') }}" method="POST">
               @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">Your Email Address</label>
                    <input type="email" class="form-control shadow rounded-pill" id="email" name="email" placeholder="Your Email ex: customer@gmail.com"
                        required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Your Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control shadow rounded-pill" placeholder="Input your Password for login"
                            aria-label="Input your Password for login" aria-describedby="basic-addon2" id="password" name="password" required>
                        <button class="btn btn-outline-secondary rounded-pill shadow ms-1" type="button" id="btn-pass"><i
                                class="fa-regular fa-eye" id="btn-eye-pass"></i></button>
                    </div>
                </div>

                <div class="text-center mt-5 rounded">
                    <button type="submit" class="btn btn-primary bg-gradient btn-md rounded-pill shadow px-5">Login</button>
                </div>
            </form>
        </div>
    </div>

    <div class="aditional-section mt-4 m-auto w-50 card-100-mobile mb-4">
      <div class="row">
         <div class="col-6">
            <a href="{{ route('forget.emailForm') }}" class="btn btn-danger btn-sm rounded-pill bg-gradient">Forget Password ?</a>
         </div>
         <div class="col-6 text-end">
            <a href="https://bubblix.id/yolo-fest/" class="btn btn-sm btn-warning rounded-pill bg-gradient"><i class="fa-solid fa-arrow-left"></i> Back to Yolo Fest</a>
         </div>
         <div class="col-12 text-center mt-5 mb-5">
            <a href="{{ route('resend.form') }}" class="btn btn-md btn-secondary rounded-pill bg-gradient"><i class="fa-regular fa-envelope"></i> Resend Verification Mail</a>
         </div>
      </div>
    </div>
</div>


@push('bottom')
<script>
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

</script>
@endpush


@endsection
