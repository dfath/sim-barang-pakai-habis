<template>
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

                        <b-field label="Perusahaan">
                            <b-input name="perusahaan" v-model="filterPerusahaan"></b-input>
                        </b-field>

                        <b-field label="Tanggal Perolehan">
                            <b-datepicker
                                placeholder="Click to select..."
                                v-model="filterTanggalPerolehan"
                                range>
                            </b-datepicker>
                        </b-field>

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
                    <b-table :data="barangMasukData" :columns="barangMasukColumns"></b-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { fetchListBarangMasuk } from '../../network/api';

export default {
    data: function () {
        return {
            filterPerusahaan: null,
            filterTanggalPerolehanMulai: null,
            filterTanggalPerolehanSelesai: null,
            barangMasukData: [],
            barangMasukColumns: [
                {
                    field: 'kelompok_kegiatan_id',
                    label: 'Kelompok Kegiatan',
                },
                {
                    field: 'kelompok_barang_id',
                    label: 'Kelompok Barang',
                },
                {
                    field: 'perusahaan_id',
                    label: 'Perusahaan',
                },
                {
                    field: 'tahun_anggaran',
                    label: 'Tahun Anggaran',
                },
                {
                    field: 'tanggal_perolehan',
                    label: 'Tanggal Perolehan',
                },
                {
                    field: 'jenis_bukti',
                    label: 'Jenis Bukti',
                },
                {
                    field: 'bukti_transaksi',
                    label: 'Bukti Transaksi',
                }
            ]
        }
    },
    computed: {
        filterTanggalPerolehan: function() {
            const today = new Date();
            return [
                new Date(today.getFullYear(), today.getMonth(), today.getDate() - 7),
                today
            ]
        }
    },
    mounted() {
        fetchListBarangMasuk().then(
            res => {
                this.barangMasukData = res.data
            }
        );
    },
}
</script>
