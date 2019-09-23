<template>
    <div class="container is-fluid">

        <br/>
        <!-- Main container -->
        <div class="level">
            <!-- Left side -->
            <div class="level-left">
                <div class="level-item">
                    <p class="control">
                        <b-select expanded placeholder="Pilih tahun anggaran" v-model="filter.tahunAnggaran">
                            <option
                                v-for="option in years"
                                :value="option"
                                :key="option">
                                {{ option }}
                            </option>
                        </b-select>
                    </p>
                </div>
                <div class="level-item">
                    <div class="field has-addons">
                        <p class="control">
                            <b-input v-model="filter.namaBarang"></b-input>
                        </p>
                        <p class="control">
                            <b-button class="button is-info" @click="applyFilter">Cari</b-button>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right side -->
            <div class="level-right">
                <p class="level-item">
                    <b-button type="is-info" @click="openCreateFormModal()">Tambah</b-button>
                </p>
            </div>

            <b-modal :active.sync="isFormModalActive" has-modal-card>
                <volume-dpa-form
                    v-bind="formModalProps"
                    v-on:submitted="onSubmitted">
                </volume-dpa-form>
            </b-modal>

            <b-modal :active.sync="isDeleteModalActive" has-modal-card :can-cancel="false">
                <delete-confirmation
                    v-bind="deleteModalProps"
                    v-on:confirmed="onConfirmed">
                </delete-confirmation>
            </b-modal>

        </div>

        <div class="columns">
            <div class="column">

                <div>
                    <b-table
                        :data="tableData"

                        striped
                        :paginated="tableTotal > 0"
                        backend-pagination
                        :loading="filter.isLoading"
                        :total="tableTotal"
                        :per-page="tablePerPage"
                        @page-change="onPageChange"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">

                        <b-message type="is-info" v-if="!filter.isLoading" slot="empty">
                            Data tidak ditemukan.
                        </b-message>

                        <template slot-scope="props">
                            <b-table-column field="tahun_anggaran" label="Tahun Anggaran">
                                {{ props.row.tahun_anggaran }}
                            </b-table-column>

                            <b-table-column field="nama_kelompok_kegiatan" label="Kelompok Kegiatan">
                                {{ props.row.nama_kelompok_kegiatan }}
                            </b-table-column>

                            <b-table-column field="nama_kelompok_barang" label="Kelompok Barang">
                                {{ props.row.nama_kelompok_barang }}
                            </b-table-column>

                            <b-table-column field="nama_barang" label="Nama Barang">
                                {{ props.row.nama_barang }}
                            </b-table-column>

                            <b-table-column field="volume" label="Volume">
                                {{ props.row.volume }}
                            </b-table-column>

                            <b-table-column field="harga_satuan" label="Harga Satuan">
                                {{ props.row.harga_satuan }}
                            </b-table-column>

                            <b-table-column label="Aksi" width="90">
                                <b-button type="is-danger" icon-right="pencil" size="is-small"
                                    @click="openUpdateFormModal({
                                        id: props.row.id,
                                        barangId: props.row.barang_id,
                                        namaBarang: props.row.nama_barang,
                                        tahunAnggaran: props.row.tahun_anggaran,
                                        volume: props.row.volume,
                                        hargaSatuan: props.row.harga_satuan,
                                    })"/>
                                <b-button type="is-danger" icon-right="delete" size="is-small"
                                    @click="openDeleteConfirmationModal({
                                        id: props.row.id,
                                        namaBarang: props.row.nama_barang
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
import { readKelompokKegiatanCollection, readKelompokBarangCollection, readVolumeDpaCollection, createVolumeDpa, updateVolumeDpa, deleteVolumeDpa } from '../../network/api';
import VolumeDpaForm from '../../components/volume-dpa/VolumeDpaForm';
import { years } from '../../utils';

export default {
    components: {
        VolumeDpaForm
    },
    data() {
        return {
            filter: {
                tahunAnggaran: new Date().getFullYear(),
                namaBarang: null,
                page: 1,
                isLoading: false,
            },
            reference: {
                kelompokKegiatanCollection: [],
                kelompokBarangCollection: [],
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
                barangId: null,
                tahunAnggaran: null,
                volume: null,
                hargaSatuan: null,
                namaBarang: null,
                isLoading: false,
                message: null,
            },
            isDeleteModalActive: false,
            deleteModalProps: {
                id: null,
                nama: null,
                isLoading: false
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
                nama_barang: this.filter.namaBarang,
                tahun_anggaran: this.filter.tahunAnggaran,
                page: this.filter.page,
            }
        },
        isCreateTypeFormModal() {
            return this.formModalProps.id === null;
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
        },
        onPageChange(page) {
            this.filter.page = page;
            this.applyFilter();
        },
        applyFilter() {
            this.filter.isLoading = true;
            readVolumeDpaCollection(this.filterParams)
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
                barangId: null,
                volume: null,
                hargaSatuan: null,
                tahunAnggaran: null,
                namaBarang: null,
                isLoading: false,
                message: null
            };
            this.isFormModalActive = true;
        },
        openUpdateFormModal(item) {
            this.formModalProps = {
                id: item.id,
                barangId: item.barangId,
                volume: item.volume,
                hargaSatuan: item.hargaSatuan,
                tahunAnggaran: item.tahunAnggaran,
                namaBarang: item.namaBarang,
                isLoading: false,
                message: null
            };
            this.isFormModalActive = true;
        },
        openDeleteConfirmationModal(item) {
            this.deleteModalProps = {
                id: item.id,
                nama: item.namaBarang,
                isLoading: false
            };
            this.isDeleteModalActive = true;
        },
        onSubmitCreate(submission) {
            this.formModalProps.isLoading = true;
            createVolumeDpa(submission)
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
            this.applyFilter();
        },
        onSubmitUpdate(submission) {
            this.formModalProps.isLoading = true;
            updateVolumeDpa(submission.id, submission)
                .then(res => {
                    this.isFormModalActive = false;
                    this.$buefy.notification.open({
                        message: `Berhasil mengubah data`,
                        type: 'is-success'
                    });
                })
                .catch(err => {
                    const message = err.response.data.error.message;
                    this.formModalProps.message = `Gagal mengubah data. ${message}`;
                })
                .finally(() => {
                    this.formModalProps.isLoading = false;
                });
            this.applyFilter();
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
            deleteVolumeDpa(submission.id)
                .then(res => {
                    this.$buefy.notification.open({
                        message: `Berhasil menghapus data`,
                        type: 'is-success'
                    })
                })
                .catch(err => {
                    const message = err.response.data.error.message;
                    this.$buefy.notification.open({
                        message: `Gagal menghapus data. ${message}`,
                        type: 'is-danger'
                    })
                })
                .finally(() => {
                    this.isDeleteModalActive = false;
                    this.deleteModalProps.isLoading = false;
                });
            this.applyFilter();
        }
    },
    beforeMount() {
        this.loadReference();
        this.applyFilter();
    }
}
</script>
