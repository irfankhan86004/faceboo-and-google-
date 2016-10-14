@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | New Location</title>
@stop

@section('content')
    <section id="main">

        @if (Auth::user()->is_admin===0)
            @include('backend.partials.sidebar-navigation')
        @else
            @include('backend.partials.sidebar-navigation_normal_user')
        @endif
        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li><a href="{{ url('admin') }}">Home</a></li>
                            <li><a href="{{ url('admin/location') }}">Locations</a></li>
                            <li class="active">New Locations</li>
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh Locations</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        @include('shared.errors')

                        @include('shared.success')

                        <h2>Create a New Locations</h2>

                    </div>
                    <div class="card-body card-padding">
                        <form class="keyboard-save" role="form" method="POST" id="LocationUpdate" action="{{ url('admin/location') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @include('backend.location.partials.form')

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-floppy"></i> Save</button>
                                &nbsp;
                                <a href="{{ url('admin/location') }}"><button type="button" class="btn btn-link">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    {!! JsValidator::formRequest('App\Http\Requests\TagCreateRequest', '#tagUpdate'); !!}

    @include('backend.shared.notifications.protip')
@stop