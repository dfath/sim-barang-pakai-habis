<template>
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-3">
                <form class="forms">
                    <div class="form-container">

                        <b-field label="Kelompok Kegiatan">
                            <b-input v-model="filterNamaKelompokKegiatan"></b-input>
                        </b-field>

                        <b-field label="Kelompok Barang">
                            <b-input v-model="filterNamaKelompokBarang"></b-input>
                        </b-field>

                        <b-field label="Perusahaan Rekanan">
                            <b-input v-model="filterNamaPerusahaan"></b-input>
                        </b-field>

                        <b-field label="Tanggal Perolehan">
                            <b-datepicker
                                placeholder="Click to select..."
                                v-model="filterTanggalPerolehan"
                                range>
                            </b-datepicker>
                        </b-field>

                        <b-field label="Bukti Transaksi">
                            <b-input v-model="filterBuktiTransaksi"></b-input>
                        </b-field>

                        <div class="field">
                            <div class="control">
                                <b-button class="button is-info is-rounded is-fullwidth" @click="applyFilter">Cari</b-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="column is-9">
                <br/>
                <b-field grouped group-multiline>
                    <b-button type="is-success" @click="openFormModal()">Tambah</b-button>
                </b-field>
                <div class="table-container">
                    <b-table
                        :data="barangMasukData"

                        striped
                        paginated
                        backend-pagination
                        :loading="isLoading"
                        :total="barangMasukTotal"
                        :per-page="barangMasukPerPage"
                        @page-change="onPageChange"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">

                        <b-notification v-if="!isLoading" :closable=false slot="empty">
                            Data tidak ditemukan.
                        </b-notification>

                        <template slot-scope="props">
                            <b-table-column field="nama_kelompok_kegiatan" label="Kelompok Kegiatan">
                                {{ props.row.nama_kelompok_barang }}
                            </b-table-column>

                            <b-table-column field="nama_kelompok_barang" label="Kelompok Barang">
                                {{ props.row.nama_kelompok_barang }}
                            </b-table-column>

                            <b-table-column field="nama_perusahaan" label="Nama Perusahaan">
                                {{ props.row.nama_perusahaan }}
                            </b-table-column>

                            <b-table-column field="tahun_anggaran" label="Tahun Anggaran">
                                {{ props.row.tahun_anggaran }}
                            </b-table-column>

                            <b-table-column field="teks_tanggal_perolehan" label="Tanggal Perolehan">
                                {{ props.row.teks_tanggal_perolehan }}
                            </b-table-column>

                            <b-table-column field="bukti_transaksi" label="Bukti Transaksi">
                                {{ props.row.bukti_transaksi }}
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
import { fetchListBarangMasuk } from '../../network/api';
import BarangMasukForm from '../../components/barang-masuk/BarangMasukForm';

export default {
    components: {
        BarangMasukForm,
    },
    data() {
        return {
            filterNamaKelompokBarang: null,
            filterNamaKelompokKegiatan: null,
            filterNamaPerusahaan: null,
            filterTanggalPerolehan: [
                new Date(new Date().getFullYear(), 0, 1),
                new Date()
            ],
            filterBuktiTransaksi: null,
            filterPage: 1,
            barangMasukData: [],
            barangMasukMeta: {
                total: null,
                per_page: null,
                current_page: null
            },
            isLoading: false
        }
    },
    computed: {
        barangMasukTotal() {
            return this.barangMasukMeta.total;
        },
        barangMasukPerPage() {
            return this.barangMasukMeta.per_page;
        },
        barangMasukCurrentPage() {
            return this.barangMasukMeta.current_page;
        },
        params() {
            return {
                nama_perusahaan: this.filterNamaPerusahaan,
                nama_kelompok_kegiatan: this.filterNamaKelompokKegiatan,
                nama_kelompok_barang: this.filterNamaKelompokBarang,
                tanggal_perolehan_mulai: this.filterTanggalPerolehan[0].toISOString().split('T')[0],
                tanggal_perolehan_selesai: this.filterTanggalPerolehan[1].toISOString().split('T')[0],
                bukti_transaksi: this.filterBuktiTransaksi,
                page: this.filterPage,
            }
        }
    },
    methods: {
        onPageChange(page) {
            this.filterPage = page;
            this.applyFilter();
        },
        applyFilter() {
            this.isLoading = true;
            fetchListBarangMasuk(this.params)
                .then(res => {
                    this.barangMasukData = res.data;
                    this.barangMasukMeta = res.meta;
                    this.isLoading = false;
                })
                .catch(err => {
                    this.isLoading = false;
                    console.error(err);
                });
        },
        openFormModal() {
            this.$buefy.modal.open({
                parent: this,
                component: BarangMasukForm,
                hasModalCard: true,
                canCancel: false,
                fullScreen: true,
            })
        }
    },
    mounted() {
        this.applyFilter();
    }
}
</script>
