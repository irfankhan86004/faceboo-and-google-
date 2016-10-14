@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Edit Location</title>
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
                            <li><a href="{{ url('admin/location') }}">Loations</a></li>
                            <li class="active">Edit Location</li>
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh Location</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        @include('shared.errors')

                        @include('shared.success')

                        <h2>
                            Edit <em>{{ $data['location_name'] }}</em>
                            <small>
                                @if(isset($data['updated_at']))
                                    Last edited on {{$data['updated_at']->format('M d, Y') }} at {{ $data['updated_at']->format('g:i A') }}
                                @else
                                    Last edited on {{ $data['created_at']->format('M d, Y') }} at {{ $data['created_at']->format('g:i A') }}
                                @endif
                            </small>
                        </h2>

                    </div>
                    <div class="card-body card-padding">
                        <form class="keyboard-save" role="form" method="POST" id="locationUpdate" action="{{ url('admin/location/' . $data['id']) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $data['id'] }}">

                            @include('backend.location.partials.form')

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-icon-text">
                                    <i class="zmdi zmdi-floppy"></i> Save
                                </button>&nbsp;
                                <button type="button" class="btn btn-danger btn-icon-text" data-toggle="modal" data-target="#modal-delete">
                                    <i class="zmdi zmdi-delete"></i> Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>

    @include('backend.location.partials.modals.delete')
@stop

@section('unique-js')
    {!! JsValidator::formRequest('App\Http\Requests\TagUpdateRequest', '#tagUpdate'); !!}

    @if(Session::get('_update-tag'))
        @include('backend.partials.notify', ['section' => '_update-tag'])
        {{ \Session::forget('_update-tag') }}
    @endif
@stop
