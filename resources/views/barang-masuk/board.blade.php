@extends('layouts.app')

@section('content')

    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Barang Masuk
                </h1>
            </div>
        </div>
    </section>

    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-3">
                <form method="get" action="" class="forms">
                    <div class="form-container">
                        <div class="field">
                            <label class="label">Tahun Anggaran</label>
                            <div class="control">
                                <input class="input" name="tahun_anggaran" type="text">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Perusahaan</label>
                            <div class="control">
                                <input class="input" name="perusahaan" type="text">
                            </div>
                        </div>

                        <example-input></example-input>

                        <range-date-picker></range-date-picker>

                        <div class="field">
                            <label class="label">Bukti Transaksi</label>
                            <div class="control">
                                <input class="input" name="bukti_transaksi" type="text">
                            </div>
                        </div>


                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-info is-rounded is-fullwidth">Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="column is-9">
                <div class="table-container">
                    <table class="table table is-striped is-fullwidth">
                        <thead>
                            <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Tanggal</th>
                            <th>Rekanan</th>
                            <th>Kelompok Kegiatan</th>
                            <th>Kelompok Barang</th>
                            <th>Bukti Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1</th>
                                <td><a href="https://en.wikipedia.org/wiki/Leicester_City_F.C." title="Leicester City F.C.">Leicester City</a> <strong>(C)</strong>
                                </td>
                                <td>38</td>
                                <td>23</td>
                                <td>12</td>
                                <td>3</td>
                                <td>68</td>
                            </tr>
                            <tr>
                                <th>2</th>
                                <td><a href="https://en.wikipedia.org/wiki/Arsenal_F.C." title="Arsenal F.C.">Arsenal</a></td>
                                <td>38</td>
                                <td>20</td>
                                <td>11</td>
                                <td>7</td>
                                <td>65</td>
                            </tr>
                            <tr>
                                <th>3</th>
                                <td><a href="https://en.wikipedia.org/wiki/Tottenham_Hotspur_F.C." title="Tottenham Hotspur F.C.">Tottenham Hotspur</a></td>
                                <td>38</td>
                                <td>19</td>
                                <td>13</td>
                                <td>6</td>
                                <td>69</td>
                            </tr>
                            <tr class="is-selected">
                                <th>4</th>
                                <td><a href="https://en.wikipedia.org/wiki/Manchester_City_F.C." title="Manchester City F.C.">Manchester City</a></td>
                                <td>38</td>
                                <td>19</td>
                                <td>9</td>
                                <td>10</td>
                                <td>71</td>
                            </tr>
                            <tr>
                                <th>5</th>
                                <td><a href="https://en.wikipedia.org/wiki/Manchester_United_F.C." title="Manchester United F.C.">Manchester United</a></td>
                                <td>38</td>
                                <td>19</td>
                                <td>9</td>
                                <td>10</td>
                                <td>49</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
