@extends('layouts.app')

@section('content')

    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Manajemen Role
                </h1>
            </div>
        </div>
    </section>

    <div class="container is-fluid">
        <br/>
        <div class="columns">

            <div class="column is-half">

                <table class="table is-bordered is-striped is-fullwidth">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Role</td>
                            <td>Guard</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($role as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->guard_name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    <div>
@endsection
