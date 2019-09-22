<template>
    <div class="container is-fluid">
        <br/>
        <div class="level">
            <div class="level-left" />
            <div class="level-right">
                 <div class="level-item">
                    <b-button type="is-info" @click="openCreateFormModal()">Tambah</b-button>
                 </div>
            </div>
        </div>

        <div class="columns">
            <div class="column is-3">
                <form class="forms">
                    <div class="form-container">

                        <b-field label="Tahun Anggaran">
                            <b-select expanded placeholder="Pilih tahun anggaran" v-model="filter.tahunAnggaran">
                                <option
                                    v-for="option in years"
                                    :value="option"
                                    :key="option">
                                    {{ option }}
                                </option>
                            </b-select>
                        </b-field>

                        <b-field label="Kelompok Kegiatan">
                            <b-input v-model="filter.namaKelompokKegiatan"></b-input>
                        </b-field>

                        <b-field label="Kelompok Barang">
                            <b-input v-model="filter.namaKelompokBarang"></b-input>
                        </b-field>

                        <b-field label="Perusahaan Rekanan">
                            <b-input v-model="filter.namaPerusahaan"></b-input>
                        </b-field>

                        <b-field label="Tanggal Perolehan">
                            <b-datepicker
                                placeholder="Click to select..."
                                v-model="filter.tanggalPerolehan"
                                range>
                            </b-datepicker>
                        </b-field>

                        <b-field label="Bukti Transaksi">
                            <b-input v-model="filter.buktiTransaksi"></b-input>
                        </b-field>

                        <div class="field">
                            <div class="control">
                                <b-button class="button is-info is-fullwidth" @click="applyFilter">Cari</b-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="column is-9">
                <b-modal :active.sync="isFormModalActive" has-modal-card>
                    <barang-masuk-form
                        v-bind="formModalProps"
                        :perusahaanCollection="reference.perusahaanCollection"
                        :kelompokKegiatanCollection="reference.kelompokKegiatanCollection"
                        :kelompokBarangCollection="reference.kelompokBarangCollection"
                        v-on:submitted="onSubmitted">
                    </barang-masuk-form>
                </b-modal>

                <div>
                    <b-table
                        :data="tableData"

                        striped
                        paginated
                        backend-pagination
                        :loading="filter.isLoading"
                        :total="tableTotal"
                        :per-page="tablePerPage"
                        @page-change="onPageChange"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">

                        <b-notification v-if="!filter.isLoading" :closable=false slot="empty">
                            Data tidak ditemukan.
                        </b-notification>

                        <template slot-scope="props">

                            <b-table-column field="tahun_anggaran" label="Tahun Anggaran">
                                {{ props.row.tahun_anggaran }}
                            </b-table-column>

                            <b-table-column field="nama_kelompok_kegiatan" label="Kelompok Kegiatan">
                                {{ props.row.nama_kelompok_barang }}
                            </b-table-column>

                            <b-table-column field="nama_kelompok_barang" label="Kelompok Barang">
                                {{ props.row.nama_kelompok_barang }}
                            </b-table-column>

                            <b-table-column field="nama_perusahaan" label="Nama Perusahaan">
                                {{ props.row.nama_perusahaan }}
                            </b-table-column>

                            <b-table-column field="teks_tanggal_perolehan" label="Tanggal Perolehan">
                                {{ props.row.teks_tanggal_perolehan }}
                            </b-table-column>

                            <b-table-column field="bukti_transaksi" label="Bukti Transaksi">
                                {{ props.row.bukti_transaksi }}
                            </b-table-column>

                            <b-table-column label="Aksi" width="120">
                                <b-button type="is-danger" icon-right="pencil" size="is-small" />
                                <b-button tag="a" :href="`/barang-masuk/${props.row.id}`" type="is-danger" icon-right="file-document-edit" size="is-small" />
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
import { readPerusahaanCollection, readKelompokKegiatanCollection, readKelompokBarangCollection, readBarangMasukCollection, createBarangMasuk } from '../../network/api';
import BarangMasukForm from '../../components/barang-masuk/BarangMasukForm';
import { years } from '../../utils';

export default {
    components: {
        BarangMasukForm,
    },
    data() {
        return {
            filter: {
                tahunAnggaran: new Date().getFullYear(),
                namaKelompokBarang: null,
                namaKelompokKegiatan: null,
                namaPerusahaan: null,
                tanggalPerolehan: [
                    new Date(new Date().getFullYear(), 0, 1),
                    new Date()
                ],
                buktiTransaksi: null,
                page: 1,
                isLoading: false
            },
            reference: {
                kelompokKegiatanCollection: [],
                kelompokBarangCollection: [],
                perusahaanCollection: [],
            },
            tableData: [],
            tableMeta: {
                total: null,
                per_page: null,
                current_page: null
            },
            isFormModalActive: false,
            formModalProps: {
                id: null,
                perusahaanId: null,
                kelompokKegiatanId: null,
                kelompokBarangId: null,
                tahunAnggaran: null,
                tanggalPerolehan: null,
                jenisBukti: null,
                buktiTransaksi: null,
                isLoading: false,
                message: null,
            },
            years: years()
        }
    },
    computed: {
        tableTotal() {
            return this.tableMeta.total;
        },
        tablePerPage() {
            return this.tableMeta.per_page;
        },
        tableCurrentPage() {
            return this.tableMeta.current_page;
        },
        filterParams() {
            return {
                tahun_anggaran: this.filter.tahunAnggaran,
                nama_perusahaan: this.filter.namaPerusahaan,
                nama_kelompok_kegiatan: this.filter.amaKelompokKegiatan,
                nama_kelompok_barang: this.filter.amaKelompokBarang,
                tanggal_perolehan_mulai: this.filter.tanggalPerolehan[0].toISOString().split('T')[0],
                tanggal_perolehan_selesai: this.filter.tanggalPerolehan[1].toISOString().split('T')[0],
                bukti_transaksi: this.filter.buktiTransaksi,
                page: this.filter.page,
            }
        }
    },
    methods: {
        loadReference() {
            readKelompokKegiatanCollection({all: true})
                .then(res => {
                    this.reference.kelompokKegiatanCollection = res.data;
                })
                .catch(err => {
                    throw err;
                });
            readKelompokBarangCollection({all: true})
                .then(res => {
                    this.reference.kelompokBarangCollection = res.data;
                })
                .catch(err => {
                    throw err;
                });
            readPerusahaanCollection({all: true})
                .then(res => {
                    this.reference.perusahaanCollection = res.data;
                })
                .catch(err => {
                    throw err;
                });
        },
        onPageChange(page) {
            this.filter.page = page;
            this.applyFilter();
        },
        applyFilter() {
            this.filter.isLoading = true;
            readBarangMasukCollection(this.filterParams)
                .then(res => {
                    this.tableData = res.data;
                    this.tableMeta = res.meta;
                })
                .catch(err => {
                    throw err;
                })
                .finally(() => {
                    this.filter.isLoading = false;
                });
        },
        openCreateFormModal() {
            this.formModalProps = {
                id: null,
                perusahaanId: null,
                kelompokKegiatanId: null,
                kelompokBarangId: null,
                tahunAnggaran: null,
                tanggalPerolehan: null,
                jenisBukti: null,
                buktiTransaksi: null,
                isLoading: false,
                message: null
            };
            this.isFormModalActive = true;
        },
        onSubmitted(submission) {
            this.formModalProps.isLoading = true;
            createBarangMasuk(submission)
                .then(res => {
                    this.isFormModalActive = false;
                    this.$buefy.notification.open({
                        message: `Berhasil menambahkan data ${res.data.bukti_transaksi}`,
                        type: 'is-success'
                    });
                })
                .catch(err => {
                    const message = err.response.data.error.message;
                    this.formModalProps.message = `Gagal menambahkan data ${submission.bukti_transaksi}. ${message}`;
                })
                .finally(() => {
                    this.formModalProps.isLoading = false;
                });
            this.applyFilter();
        },
    },
    mounted() {
        this.loadReference();
        this.applyFilter();
    }
}
</script>
