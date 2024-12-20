@extends('auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', __('adminlte.verify_message'))

@section('auth_body')

@if(session('resent'))
<div class="alert alert-success" role="alert">
    {{ __('adminlte.verify_email_sent') }}
</div>
@endif

{{ __('adminlte.verify_check_your_email') }}
{{ __('adminlte.verify_if_not_recieved') }},

<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
        {{ __('adminlte.verify_request_another') }}
    </button>.
</form>

@stop