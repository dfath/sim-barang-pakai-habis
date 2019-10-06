@extends('layouts.app')

@section('content')
    <section class="hero is-light is-fullheight">
        <div class="hero-body">
            <div class="container">

                <div class="columns is-marginless is-centered">
                    <div class="column is-half">
                        <div class="card">
                            <div class="card-content">

                                <div class="media">
                                    <div class="media-left">
                                        <figure class="image is-48x48 is-4by5">
                                            <img src="{{ asset('img/logo.png') }}" alt="logo">
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <p class="title is-4">{{ config('app.name', 'Laravel') }}</p>
                                        <p class="subtitle is-6">Sistem Informasi Barang Pakai Habis</p>
                                    </div>
                                </div>

                            </div>

                            <div class="card-content">

                                <form class="login-form" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}

                                    <div class="field is-horizontal">
                                        <div class="field-label">
                                            <label class="label">E-Mail</label>
                                        </div>

                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <input class="input" id="email" type="email" name="email"
                                                        value="{{ old('email') }}" required autofocus>
                                                </p>

                                                @if ($errors->has('email'))
                                                    <p class="help is-danger">
                                                        {{ $errors->first('email') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field is-horizontal">
                                        <div class="field-label">
                                            <label class="label">Password</label>
                                        </div>

                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <input class="input" id="password" type="password" name="password" required>
                                                </p>

                                                @if ($errors->has('password'))
                                                    <p class="help is-danger">
                                                        {{ $errors->first('password') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field is-horizontal">
                                        <div class="field-label"></div>

                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <label class="checkbox">
                                                        <input type="checkbox"
                                                            name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field is-horizontal">
                                        <div class="field-label"></div>

                                        <div class="field-body">
                                            <div class="field is-grouped">
                                                <div class="control">
                                                    <button type="submit" class="button is-primary">Login</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


@endsection
