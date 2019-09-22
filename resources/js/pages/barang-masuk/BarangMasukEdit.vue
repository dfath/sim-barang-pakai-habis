<template>
    <div class="container is-fluid">
        <br/>
        <div class="columns">

            <div class="column is-half">
                <table class="table is-fullwidth">
                    <tbody>
                        <tr>
                            <td>Tahun Anggaran</td>
                            <td>{{ barangMasukData.tahun_anggaran }}</td>
                        </tr>
                        <tr>
                            <td>Kelompok Kegiatan</td>
                            <td>{{ barangMasukData.nama_kelompok_kegiatan }}</td>
                        </tr>
                        <tr>
                            <td>Kelompok Barang</td>
                            <td>{{ barangMasukData.nama_kelompok_barang }}</td>
                        </tr>
                        <tr>
                            <td>Nama Perusahaan</td>
                            <td>{{ barangMasukData.nama_perusahaan }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Perolehan</td>
                            <td>{{ barangMasukData.tanggal_perolehan }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Bukti</td>
                            <td>{{ barangMasukData.jenis_bukti }}</td>
                        </tr>
                        <tr>
                            <td>Bukti Transaksi</td>
                            <td>{{ barangMasukData.bukti_transaksi }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="columns">

            <div class="column is-four-fifths">

                <div class="level">
                    <div class="level-left" />
                    <div class="level-right">
                        <div class="level-item">
                            <b-button type="is-info" >Tambah</b-button>
                        </div>
                    </div>
                </div>

                <div>
                    <b-table
                        :data="barangMasukDetilData"

                        striped
                        :loading="barangMasukDetil.isLoading">

                        <b-notification v-if="!barangMasukDetil.isLoading" :closable=false slot="empty">
                            Data tidak ditemukan.
                        </b-notification>

                        <template slot-scope="props">

                            <b-table-column field="nama_barang" label="Nama Barang">
                                {{ props.row.nama_barang }}
                            </b-table-column>

                            <b-table-column field="volume" label="Volume">
                                {{ props.row.volume }}
                            </b-table-column>

                            <b-table-column field="harga_satuan" label="Harga Satuan">
                                {{ props.row.harga_satuan }}
                            </b-table-column>

                            <b-table-column field="total" label="Total">
                                {{ props.row.total }}
                            </b-table-column>

                            <b-table-column label="Aksi" width="90">
                                <b-button type="is-danger" icon-right="pencil" size="is-small" />
                                <b-button type="is-danger" icon-right="delete" size="is-small" />
                            </b-table-column>

                        </template>

                    </b-table>
                </div>

            </div>

        </div>

    </div>
</template>

<script>
import { readBarangMasuk, readBarangMasukDetilCollection, updateBarangMasukDetil, readBarangMasukDetil, deleteBarangMasukDetil, createBarangMasukDetil } from '../../network/api';

export default {
    components: {
    },
    props: {
        id: Number
    },
    data() {
        return {
            barangMasuk: {
                isLoading: false
            },
            barangMasukData: {},
            barangMasukDetil: {
                isLoading: false
            },
            barangMasukDetilData: []
        }
    },
    computed: {
    },
    methods: {
        loadBarangMasuk() {
            this.barangMasuk.isLoading = true;
            readBarangMasuk(this.id)
                .then(res => {
                    this.barangMasukData = {...this.barangMasukData, ...res.data};
                })
                .catch(err => {
                    throw err;
                })
                .finally(() => {
                    this.barangMasuk.isLoading = false;
                });
        },
        loadBarangMasukDetil() {
            this.barangMasukDetil.isLoading = true;
            const filter = {
                all: true,
                barang_masuk_id: this.id,
            };
            readBarangMasukDetilCollection(filter)
                .then(res => {
                    this.barangMasukDetilData = res.data;
                })
                .catch(err => {
                    throw err;
                })
                .finally(() => {
                    this.barangMasukDetil.isLoading = false;
                });
        },
    },
    mounted() {
        this.loadBarangMasuk();
        this.loadBarangMasukDetil();
    }
}
</script>
