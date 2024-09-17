@extends('layouts.app')

@section('content')
    <section>
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <h4><strong>ระบบตรวจสอบเครื่องจักร </strong></h4>


                    {{-- <h4>ปิดปรับปรุง</h4> --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-outline mb-3">
                            <input type="text" id="form3Example3" name="username" class="form-control form-control-lg"
                                placeholder="Enter Username" />
                            <label class="form-label" for="form3Example3">Username</label>
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example4" name="password" class="form-control form-control-lg"
                                placeholder="Enter password" />
                            <label class="form-label" for="form3Example4">Password</label>
                        </div>

                        <div class="text-center text-lg-start mt-3 pt-2">
                            <button type="bubmit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection
