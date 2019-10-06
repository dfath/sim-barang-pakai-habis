@extends('layouts.app')

@section('content')
    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Set Role
                </h1>
            </div>
        </div>
    </section>

    <div class="container is-fluid">
        <br/>
        <div class="columns">

            <div class="column is-half">

                <form action="{{ route('users.set_role', $user->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <!-- nama -->
                    <div class="field">
                        <label class="label">Nama</label>
                        <div class="control">
                            <input class="input" type="text" value="{{ $user->name }}" disabled>
                        </div>
                    </div>

                    <!-- email -->
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="text" value="{{ $user->email }}" disabled>
                        </div>
                    </div>

                    <!-- role -->
                    <div class="field">
                        <label class="label">Role</label>
                        <div class="control">

                            @foreach ($roles as $row)
                                <label class="radio">
                                    <input type="radio" name="role" {{ $user->hasRole($row) ? 'checked':'' }}
                                        value="{{ $row }}"> {{  $row }}
                                </label>
                                <br/>
                            @endforeach
                        </div>
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
