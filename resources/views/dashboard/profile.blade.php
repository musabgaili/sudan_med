@extends('dash')


@section('content')
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Profile</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            @if (Session::has('password-success'))
                <p class="alert alert-info">{{ Session::get('password-success') }}</p>
            @endif
            <!-- Row -->
            <div class="row">

                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-12 col-xlg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal form-material mx-2" method="POST"
                                action="{{ route('dash.update_password') }}">
                                @csrf
                                <small style="color:red">Only Password can be updated</small>

                                <div class="form-group">
                                    <label class="col-md-12 mb-0">Name</label>
                                    <div class="col-md-12">
                                        <input type="text" disabled value="{{ Auth::user()->name }}"
                                            class="form-control ps-0 form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" disabled value="{{ Auth::user()->email }}"
                                            class="form-control ps-0 form-control-line" name="example-email"
                                            id="example-email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 mb-0">Password</label>
                                    <div class="col-md-12">
                                        <input type="password" required name="password"
                                            class="form-control  @error('password') is-invalid @enderror ">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 mb-0">Phone No</label>
                                    <div class="col-md-12">
                                        <input type="text" value="{{ Auth::user()->phone }}" disabled
                                            class="form-control ps-0 form-control-line">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12 d-flex">
                                        <button type="submit" class="btn btn-success mx-auto mx-md-0 text-white">Update
                                            Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
            <!-- Row -->
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
@endsection
