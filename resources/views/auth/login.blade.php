@extends('layouts.login')

{{-- Page Title --}}
@section('page-title', 'Login')

@section('content')
    <div class="login-box with-border">
        <div class="login-logo">
            <a href="#">VATUSA <strong>TMS</strong></a>
        </div>
        <!-- /.login-logo -->
        @include('flash::message')
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to access v<strong>TMS</strong></p>

            <div class="social-auth-links text-center">
                <a href="{{ route('login') }}"
                   onclick="event.preventDefault(); document.getElementById('login-form').submit();"
                   class="btn btn-block btn-social btn-linkedin btn-flat"><i
                        class="fas fa-paper-plane"></i>
                    Sign in with
                    VATSIM</a>
                <a href="{{ route('login') }}"
                   onclick="event.preventDefault(); document.getElementById('login-form').submit();"
                   class="btn btn-block btn-social btn-warning btn-flat"><i
                        class="fas fa-user"></i>
                    Continue as Guest</a>
            </div>
            <form id="login-form" action="{{ url('login') }}" method="post" style="display:none;">
                @csrf
            </form>
            <!-- /.social-auth-links -->
            <p class="text-muted">The Traffic Management System allows for the prediction and supervision of VATSIM
                traffic.
                <br>
                <strong>For use with flight simulation only.</strong></p>
            <div class="box-footer">
                <p class="text-center">
                    <a href="https://github.com/bnahin/vattms"
                       class="pull-left" data-toggle="tooltip" title="View Source on GitHub"><i
                            class="fab fa-github"></i></a>
                    <a href="/privacy" class="pull-right" data-toggle="tooltip" title="Privacy Policy">
                        <i class="fas fa-user-lock"></i></a>
                    v0.1a</p>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
