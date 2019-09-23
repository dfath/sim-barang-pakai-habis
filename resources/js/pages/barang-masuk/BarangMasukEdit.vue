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

            <div class="column">

                <div class="level">
                    <div class="level-left" />
                    <div class="level-right">
                        <div class="level-item">
                            <b-button type="is-info" @click="openCreateFormModal()">Tambah</b-button>
                        </div>
                    </div>

                    <b-modal :active.sync="isFormModalActive" has-modal-card>
                        <barang-masuk-detil-form
                            v-bind="formModalProps"
                            v-on:submitted="onSubmitted">
                        </barang-masuk-detil-form>
                    </b-modal>

                    <b-modal :active.sync="isDeleteModalActive" has-modal-card :can-cancel="false">
                        <delete-confirmation
                            v-bind="deleteModalProps"
                            v-on:confirmed="onConfirmed">
                        </delete-confirmation>
                    </b-modal>

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
                                <b-button type="is-danger" icon-right="pencil" size="is-small"
                                    @click="openUpdateFormModal(props.row)"/>
                                <b-button type="is-danger" icon-right="delete" size="is-small"
                                    @click="openDeleteConfirmationModal({
                                        id: props.row.id,
                                        nama: props.row.nama_barang
                                    })"/>
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
import BarangMasukDetilForm from '../../components/barang-masuk-detil/BarangMasukDetilForm';

export default {
    components: {
        BarangMasukDetilForm
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
            barangMasukDetilData: [],
            isFormModalActive: false,
            formModalProps: {
                id: null,
                barangMasukId: this.id,
                volumeDpaId: null,
                volume: null,
                tahunAnggaran: null,
                kelompokBarangId: null,
                kelompokKegiatanId: null,
                namaBarang: null,
                isLoading: false,
                message: null,
            },
            isDeleteModalActive: false,
            deleteModalProps: {
                id: null,
                nama: null,
                isLoading: false
            }
        }
    },
    computed: {
        isCreateTypeFormModal() {
            return this.formModalProps.id === null;
        }
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
        openCreateFormModal() {
            this.formModalProps = {
                id: null,
                barangMasukId: this.id,
                volumeDpaId: null,
                volume: null,
                tahunAnggaran: this.barangMasukData.tahun_anggaran,
                kelompokBarangId: this.barangMasukData.kelompok_barang_id,
                kelompokKegiatanId: this.barangMasukData.kelompok_kegiatan_id,
                namaBarang: null,
                isLoading: false,
                message: null,
            };
            this.isFormModalActive = true;
        },
        openUpdateFormModal(item) {
            console.log(item);
            this.formModalProps = {
                id: item.id,
                barangMasukId: this.id,
                volumeDpaId: item.volume_dpa_id,
                volume: item.volume,
                tahunAnggaran: item.tahun_anggaran,
                kelompokBarangId: item.kelompok_barang_id,
                kelompokKegiatanId: item.kelompok_kegiatan_id,
                namaBarang: item.nama_barang,
                isLoading: false,
                message: null,
            };
            this.isFormModalActive = true;
        },
        openDeleteConfirmationModal(item) {
            this.deleteModalProps = {
                id: item.id,
                nama: item.nama,
                isLoading: false
            };
            this.isDeleteModalActive = true;
        },
        onSubmitCreate(submission) {
            this.formModalProps.isLoading = true;
            createBarangMasukDetil(submission)
                .then(res => {
                    this.isFormModalActive = false;
                    this.$buefy.notification.open({
                        message: `Berhasil menambahkan data`,
                        type: 'is-success'
                    });
                })
                .catch(err => {
                    const message = err.response.data.error.message;
                    this.formModalProps.message = `Gagal menambahkan data. ${message}`;
                })
                .finally(() => {
                    this.formModalProps.isLoading = false;
                });
            this.loadBarangMasukDetil();
        },
        onSubmitUpdate(submission) {
            this.formModalProps.isLoading = true;
            updateBarangMasukDetil(submission.id, submission)
                .then(res => {
                    this.isFormModalActive = false;
                    this.$buefy.notification.open({
                        message: `Berhasil mengubah data`,
                        type: 'is-success'
                    });
                })
                .catch(err => {
                    const message = err.response.data.error.message;
                    this.formModalProps.message = `Gagal mengubah data ${submission.nama_barang}. ${message}`;
                })
                .finally(() => {
                    this.formModalProps.isLoading = false;
                });
            this.loadBarangMasukDetil();
        },
        onSubmitted(submission) {
            if (this.isCreateTypeFormModal) {
                this.onSubmitCreate(submission);
            } else {
                this.onSubmitUpdate(submission);
            }
        },
        onConfirmed(submission) {
            this.deleteModalProps.isLoading = true;
            deleteBarangMasukDetil(submission.id)
                .then(res => {
                    this.$buefy.notification.open({
                        message: `Berhasil menghapus data ${submission.nama}`,
                        type: 'is-success'
                    })
                })
                .catch(err => {
                    const message = err.response.data.error.message;
                    this.$buefy.notification.open({
                        message: `Gagal menghapus data ${submission.nama}. ${message}`,
                        type: 'is-danger'
                    })
                })
                .finally(() => {
                    this.isDeleteModalActive = false;
                    this.deleteModalProps.isLoading = false;
                });
            this.loadBarangMasukDetil();
        }
    },
    mounted() {
        this.loadBarangMasuk();
        this.loadBarangMasukDetil();
    }
}
</script>
