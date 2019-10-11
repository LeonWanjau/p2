@extends('project_views/base_views/base')

@section('title')
{{"Password Reset Status"}}
@endsection

@section('body')

<div class="card-container">
    <div class="mdc-card">
        <p>
            @isset($password_reset)
            @if($password_reset==true)
            {{"You Password has been Reset"}}
            @elseif($password_reset==false)
            {{"An error has occured in resetting your password"}}
            @endif
            @endisset
        </p>
    </div>
</div>

<script src="{{asset('js/project/authentication/password_reset_status_page.js')}}" async></script>

@endsection