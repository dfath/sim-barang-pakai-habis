<template>
    <div class="container is-fluid">

        <br/>
        <!-- Main container -->
        <div class="level">
            <!-- Left side -->
            <div class="level-left">
                <div class="level-item">
                <div class="field has-addons">
                    <p class="control">
                        <b-input v-model="filter.nama"></b-input>
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
                <barang-keluar-form
                    v-bind="formModalProps"
                    :unitKerjaCollection="reference.unitKerjaCollection"
                    :kelompokKegiatanCollection="reference.kelompokKegiatanCollection"
                    :kelompokBarangCollection="reference.kelompokBarangCollection"
                    v-on:submitted="onSubmitted">
                </barang-keluar-form>
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
                            <b-table-column field="nama_unit_kerja" label="Unit Kerja">
                                {{ props.row.nama_unit_kerja }}
                            </b-table-column>

                            <b-table-column field="nama_kelompok_kegiatan" label="Kelompok Kegiatan">
                                {{ props.row.nama_kelompok_kegiatan }}
                            </b-table-column>

                            <b-table-column field="nama_kelompok_barang" label="Kelompok Barang">
                                {{ props.row.nama_kelompok_barang }}
                            </b-table-column>

                            <b-table-column field="nama_barang" label="Barang">
                                {{ props.row.nama_barang }}
                            </b-table-column>

                            <b-table-column field="tanggal" label="Tanggal">
                                {{ props.row.teks_tanggal }}
                            </b-table-column>

                            <b-table-column field="volume" label="Volume">
                                {{ props.row.volume }}
                            </b-table-column>

                            <b-table-column label="Aksi" width="90">
                                <b-button type="is-danger" icon-right="pencil" size="is-small"
                                    @click="openUpdateFormModal(props.row)"/>
                                <b-button type="is-danger" icon-right="delete" size="is-small"
                                    @click="openDeleteConfirmationModal(props.row)"/>
                            </b-table-column>

                        </template>

                    </b-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { readUnitKerjaCollection, readKelompokKegiatanCollection, readKelompokBarangCollection, readBarangKeluarCollection, createBarangKeluar, updateBarangKeluar, deleteBarangKeluar } from '../../network/api';
import BarangKeluarForm from '../../components/barang-keluar/BarangKeluarForm';

export default {
    components: {
        BarangKeluarForm
    },
    data() {
        return {
            filter: {
                nama: null,
                page: 1,
                isLoading: false,
            },
            reference: {
                kelompokKegiatanCollection: [],
                kelompokBarangCollection: [],
                unitKerjaCollection: [],
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
                kelompokKegiatanId: null,
                kelompokBarangId: null,
                barangId: null,
                namaBarang: null,
                unitKerjaId: null,
                volume: null,
                tanggal: null,
                isLoading: false,
                message: null
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
                nama_barang: this.filter.nama,
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
            readUnitKerjaCollection({all: true})
                .then(res => {
                    this.reference.unitKerjaCollection = res.data;
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
            readBarangKeluarCollection(this.filterParams)
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
                kelompokKegiatanId: null,
                kelompokBarangId: null,
                barangId: null,
                namaBarang: null,
                unitKerjaId: null,
                volume: null,
                tanggal: null,
                isLoading: false,
                message: null
            };
            this.isFormModalActive = true;
        },
        openUpdateFormModal(item) {
            this.formModalProps = {
                id: item.id,
                kelompokKegiatanId: item.kelompok_kegiatan_id,
                kelompokBarangId: item.kelompok_barang_id,
                barangId: item.barang_id,
                namaBarang: item.nama_barang,
                unitKerjaId: item.unit_kerja_id,
                volume: item.volume,
                tanggal: new Date(item.tanggal),
                isLoading: false,
                message: null
            };
            this.isFormModalActive = true;
        },
        openDeleteConfirmationModal(item) {
            this.deleteModalProps = {
                id: item.id,
                nama: item.nama_unit_kerja,
                isLoading: false
            };
            this.isDeleteModalActive = true;
        },
        onSubmitCreate(submission) {
            this.formModalProps.isLoading = true;
            createBarangKeluar(submission)
                .then(res => {
                    this.isFormModalActive = false;
                    this.$buefy.notification.open({
                        message: `Berhasil menambahkan data barang keluar`,
                        type: 'is-success'
                    });
                })
                .catch(err => {
                    const message = err.response.data.error.message;
                    this.formModalProps.message = `Gagal menambahkan data barang keluar. ${message}`;
                })
                .finally(() => {
                    this.formModalProps.isLoading = false;
                });
            this.applyFilter();
        },
        onSubmitUpdate(submission) {
            this.formModalProps.isLoading = true;
            updateBarangKeluar(submission.id, submission)
                .then(res => {
                    this.isFormModalActive = false;
                    this.$buefy.notification.open({
                        message: `Berhasil mengubah data barang keluar`,
                        type: 'is-success'
                    });
                })
                .catch(err => {
                    const message = err.response.data.error.message;
                    this.formModalProps.message = `Gagal mengubah data barang keluar. ${message}`;
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
            deleteBarangKeluar(submission.id)
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
            this.applyFilter();
        }
    },
    mounted() {
        this.loadReference();
        this.applyFilter();
    }
}
</script>
