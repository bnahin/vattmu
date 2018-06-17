@extends('layouts.frontend')

{{-- Page Title --}}
@section('page-title', 'Login')

@section('content')
    <div class="login-box with-border">
        <div class="login-logo">
            <a href="../../index2.html">VATUSA <strong>TMS</strong></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to access v<strong>TMS</strong></p>

            <div class="social-auth-links text-center">
                <a href="#" class="btn btn-block btn-social btn-linkedin btn-flat"><i class="fas fa-paper-plane"></i>
                    Sign in with
                    VATSIM</a>
            </div>
            <!-- /.social-auth-links -->
            <p class="text-muted">The Traffic Management System allows for the prediction and supervision of VATSIM
                traffic.
                <br>
                <strong>For use with flight simulation only.</strong></p>
            <div class="box-footer">
                <p class="text-center">
                    <a href="https://github.com/bnahin/vattms"
                       class="pull-left" data-toggle="tooltip" title="View Source on GitHub" ><i
                            class="fab fa-github"></i></a>
                    <a href="/privacy" class="pull-right" data-toggle="tooltip" title="Privacy Policy">
                        <i class="fas fa-user-lock"></i></a>
                    v0.1a</p>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
