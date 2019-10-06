@extends('layouts.app')

@section('content')
    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Ubah pengguna
                </h1>
            </div>
        </div>
    </section>

    <div class="container is-fluid">
        <br/>
        <div class="columns">

            <div class="column is-half">

                <form action="{{ route('users.update', $user->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <!-- nama -->
                    <div class="field">
                        <label class="label">Nama</label>
                        <div class="control">
                            <input class="input {{ $errors->has('name') ? 'is-danger':'' }}" value="{{ $user->name }}" type="text" name="name" required>
                        </div>
                        <p class="help is-danger">{{ $errors->first('name') }}</p>
                    </div>

                    <!-- email -->
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input {{ $errors->has('email') ? 'is-danger':'' }}" value="{{ $user->email }}" type="email" name="email" required>
                        </div>
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    </div>

                    <!-- password -->
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input {{ $errors->has('password') ? 'is-danger':'' }}" type="password" name="password">
                        </div>
                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                        <p class="help is-info">Biarkan kosong, jika tidak ingin mengganti password</p>
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
