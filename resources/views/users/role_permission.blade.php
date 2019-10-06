@extends('layouts.app')

@section('content')
    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Role Permission
                </h1>
            </div>
        </div>
    </section>

    <div class="container is-fluid">
        <br/>
        <div class="columns">
            <div class="column is-half">
                <div class="panel">
                    <p class="panel-heading">
                        Add New Permission
                    </p>
                    <div class="panel-block">
                        <form action="{{ route('users.add_permission') }}" method="post">
                            @csrf
                            <!-- nama -->
                            <div class="field">
                                <label class="label">Nama</label>
                                <div class="control">
                                    <input class="input {{ $errors->has('name') ? 'is-danger':'' }}" type="text" name="name" required>
                                </div>
                                <p class="help is-danger">{{ $errors->first('name') }}</p>
                            </div>

                            <!-- button -->
                            <div class="buttons">
                                <button type="submit" class="button is-info"><span>Simpan</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="column is-half">
                <div class="panel">
                    <p class="panel-heading">
                        Set Permission to Role
                    </p>
                    <div class="panel-block">
                        <form action="{{ route('users.roles_permission') }}" method="get">

                            <!-- role -->
                            <div class="field">
                                <label class="label">Role</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select name="role" class="" required>
                                            @foreach ($roles as $value)
                                                <option value="{{ $value }}" {{ request()->get('role') == $value ? 'selected':'' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- button -->
                            <div class="buttons">
                                <button type="submit" class="button is-info"><span>Check!</span></button>
                            </div>
                        </form>
                    </div>
                    @if (!empty($permissions))
                    <div class="panel-block">
                        <form action="{{ route('users.setRolePermission', request()->get('role')) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">

                            <!-- role -->
                            <div class="field">
                                <label class="label">Permissions</label>
                                <div class="control">

                                    @php $no = 1; @endphp
                                    @foreach ($permissions as $key => $row)
                                        <label class="checkbox">
                                            <input type="checkbox"
                                                name="permission[]"
                                                class="minimal-red"
                                                value="{{ $row }}"
                                                {{ in_array($row, $hasPermission) ? 'checked':'' }}
                                                > {{ $row }}
                                        </label>
                                        <br/>
                                        @if ($no++%4 == 0)
                                        <br/>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- button -->
                            <div class="buttons">
                                <button type="submit" class="button is-info"><span>Set Permission</span></button>
                            </div>
                        </form>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    <div>

    <!-- <div class="content-wrapper">


        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-8">
                        @card
                            @slot('title')
                            Set Permission to Role
                            @endslot

                            @if (session('success'))
                                @alert(['type' => 'success'])
                                    {{ session('success') }}
                                @endalert
                            @endif


                            @if (!empty($permissions))
                                <form action="{{ route('users.setRolePermission', request()->get('role')) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="form-group">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#tab_1" data-toggle="tab">Permissions</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1">
                                                    @php $no = 1; @endphp
                                                    @foreach ($permissions as $key => $row)
                                                        <input type="checkbox"
                                                            name="permission[]"
                                                            class="minimal-red"
                                                            value="{{ $row }}"
                                                            {{--  CHECK, JIKA PERMISSION TERSEBUT SUDAH DI SET, MAKA CHECKED --}}
                                                            {{ in_array($row, $hasPermission) ? 'checked':'' }}
                                                            > {{ $row }} <br>
                                                        @if ($no++%4 == 0)
                                                        <br>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-send"></i> Set Permission
                                        </button>
                                    </div>
                                </form>
                            @endif
                            @slot('footer')

                            @endslot
                        @endcard
                    </div>
                </div>
            </div>
        </section>
    </div> -->
@endsection
