@extends('layouts.app')

@section('content')

    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Instansi
                </h1>
            </div>
        </div>

    </section>


    <div class="container is-fluid">
        <br/>
        <div class="columns">
            <div class="column is-half">


                @if (count($message))
                    <article class="message {{ $message['color'] }}">
                        <div class="message-body">
                            {{ $message['content'] }}
                        </div>
                    </article>
                @endif

                <form action="/instansi" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <!-- nama aplikasi -->
                    <div class="field">
                        <label class="label">Nama Aplikasi</label>
                        <div class="control">
                            <input class="input" type="text" name="nama_aplikasi" value="{{ $instansi->nama_aplikasi }}">
                        </div>
                    </div>

                    <!-- nama instansi -->
                    <div class="field">
                        <label class="label">Nama Instansi</label>
                        <div class="control">
                            <input class="input" type="text" name="nama_instansi" value="{{ $instansi->nama_instansi }}">
                        </div>
                    </div>

                    <!-- alamat instansi -->
                    <div class="field">
                        <label class="label">Alamat Instansi</label>
                        <div class="control">
                            <textarea class="textarea" name="alamat_instansi">{{ $instansi->alamat_instansi }}</textarea>
                        </div>
                    </div>


                    <!-- kepala opd -->
                    <div class="field">
                        <label class="label">Kepala Opd</label>
                        <div class="control">
                            <input class="input" type="text" name="kepala_opd" value="{{ $instansi->kepala_opd }}">
                        </div>
                    </div>

                    <!-- pengelola -->
                    <div class="field">
                        <label class="label">Pengelola</label>
                        <div class="control">
                            <input class="input" type="text" name="pengelola" value="{{ $instansi->pengelola }}">
                        </div>
                    </div>

                    <!-- file -->
                    <div class="field">
                        <label class="label">Logo Instansi</label>
                        <div class="control">

                            <div class="file">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="logo">
                                    <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Pilih file…
                                        </span>
                                    </span>
                                </label>
                            </div>

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
