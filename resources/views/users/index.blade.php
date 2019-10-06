@extends('layouts.app')

@section('content')

    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Manajemen User
                </h1>
            </div>
        </div>
    </section>

    <div class="container is-fluid">
        <br/>

        <div class="level">
            <div class="level-left">
                <p class="level-item">
                    <a href="/users/create" class="button is-info">Tambah</a>
                </p>
            </div>

        </div>

        <div class="columns">

            <div class="column is-three-quarters">

                <table class="table is-bordered is-striped is-fullwidth">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Nama</td>
                            <td>Email</td>
                            <td>Role</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($users as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>
                                @foreach ($row->getRoleNames() as $role)
                                <label for="" class="badge badge-info">{{ $role }}</label>
                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('users.destroy', $row->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="{{ route('users.roles', $row->id) }}" class="button is-danger is-small"><i class="fa fa-user-secret"></i></a>
                                    <a href="{{ route('users.edit', $row->id) }}" class="button is-danger is-small"><i class="fa fa-edit"></i></a>
                                    <button class="button is-danger is-small"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    <div>
@endsection
