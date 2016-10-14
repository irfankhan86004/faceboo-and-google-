@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Locations</title>
@stop

@section('content')
    <section id="main">

        @if ($user_level===0)
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
                            <li class="active">Locations</li>
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

                        <h2>Locations&nbsp;
                            <a href="{{ url('admin/location/create') }}"><i class="zmdi zmdi-plus-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Create a new location"></i></a>

                            <small>This page provides a comprehensive overview of all your blog Locations. Click the <span class="zmdi zmdi-edit text-primary"></span> icon next to each location to update its contents.</small>
                        </h2>
                    </div>

                    <div class="table-responsive">
                        <table id="Locations" class="table table-condensed table-vmiddle">
                            <thead>
                            <tr>
                                <th data-column-id="id" data-type="numeric" data-sortable="false">Id</th>
                                <th data-column-id="title" data-order="desc">Location</th>
                                <th data-column-id="created" data-type="date">Created</th>
                                <th data-column-id="commands" data-formatter="commands" data-sortable="false">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $tag)
                                <tr>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->location_name }}</td>
                                    <td>{{ $tag->created_at->format('M d, Y') }}</td>
                                    <td><a href="{{ url('admin/location/'.$tag->id .'/edit') }}"><i class="zmdi zmdi-edit"></i></a> </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @include('backend.tag.partials.datatable')

    @if(Session::get('_new-tag'))
        @include('backend.partials.notify', ['section' => '_new-tag'])
        {{ \Session::forget('_new-tag') }}
    @endif

    @if(Session::get('_delete-tag'))
        @include('backend.partials.notify', ['section' => '_delete-tag'])
        {{ \Session::forget('_delete-tag') }}
    @endif
@stop
