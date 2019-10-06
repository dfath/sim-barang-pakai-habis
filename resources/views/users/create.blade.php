@extends('layouts.app')

@section('content')
    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Tambah pengguna baru
                </h1>
            </div>
        </div>
    </section>

    <div class="container is-fluid">
        <br/>
        <div class="columns">

            <div class="column is-half">

                <form action="{{ route('users.store') }}" method="post">
                    @csrf

                    <!-- nama -->
                    <div class="field">
                        <label class="label">Nama</label>
                        <div class="control">
                            <input class="input {{ $errors->has('name') ? 'is-danger':'' }}" type="text" name="name" required>
                        </div>
                        <p class="help is-danger">{{ $errors->first('name') }}</p>
                    </div>

                    <!-- email -->
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input {{ $errors->has('email') ? 'is-danger':'' }}" type="email" name="email" required>
                        </div>
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    </div>

                    <!-- password -->
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input {{ $errors->has('password') ? 'is-danger':'' }}" type="password" name="password" required>
                        </div>
                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                    </div>

                    <!-- role -->
                    <div class="field">
                        <label class="label">Role</label>
                        <div class="control">
                            <div class="select is-fullwidth {{ $errors->has('role') ? 'is-danger':'' }}">
                                <select name="role" class="" required>
                                    <option value="">Pilih</option>
                                    @foreach ($role as $row)
                                    <option value="{{ $row->name }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p class="help is-danger">{{ $errors->first('role') }}</p>
                    </div>

                    <!-- button -->
                    <div class="buttons">
                        <button type="submit" class="button is-info"><span>Simpan</span></button>
                    </div>

                </form>

            </div>
        </div>
    <div>

@endsection
