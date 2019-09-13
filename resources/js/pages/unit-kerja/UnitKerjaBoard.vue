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
                    <b-button type="is-success" @click="openCreateFormModal()">Tambah</b-button>
                </p>
            </div>

            <b-modal :active.sync="isFormModalActive" has-modal-card :can-cancel="false">
                <unit-kerja-form
                    v-bind="formModalProps"
                    v-on:submitted="onSubmitted">
                </unit-kerja-form>
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

                <div class="table-container">
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
                            <b-table-column field="nama" label="Nama">
                                {{ props.row.nama }}
                            </b-table-column>

                            <b-table-column label="Aksi" width="90">
                                <b-button type="is-danger" icon-right="pencil" size="is-small"
                                    @click="openUpdateFormModal({
                                        id: props.row.id,
                                        nama: props.row.nama
                                    })"/>
                                <b-button type="is-danger" icon-right="delete" size="is-small"
                                    @click="openDeleteConfirmationModal({
                                        id: props.row.id,
                                        nama: props.row.nama
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
import { readUnitKerjaCollection, createUnitKerja, updateUnitKerja, deleteUnitKerja } from '../../network/api';
import UnitKerjaForm from '../../components/unit-kerja/UnitKerjaForm';

export default {
    components: {
        UnitKerjaForm
    },
    data() {
        return {
            filter: {
                nama: null,
                page: 1,
                isLoading: false,
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
                nama: null,
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
                nama: this.filter.nama,
                page: this.filter.page,
            }
        },
        isCreateTypeFormModal() {
            return this.formModalProps.id === null;
        }
    },
    methods: {
        snackbar(message, type) {
            this.$buefy.snackbar.open({
                message,
                type,
            });
        },
        onPageChange(page) {
            this.filter.page = page;
            this.applyFilter();
        },
        applyFilter() {
            this.filter.isLoading = true;
            readUnitKerjaCollection(this.filterParams)
                .then(res => {
                    this.tableData = res.data;
                    this.tableMeta = res.meta;
                    this.filter.isLoading = false;
                })
                .catch(err => {
                    this.filter.isLoading = false;
                });
        },
        openCreateFormModal() {
            this.formModalProps = {
                id: null,
                nama: null,
                isLoading: false,
                message: null
            };
            this.isFormModalActive = true;
        },
        openUpdateFormModal(item) {
            this.formModalProps = {
                id: item.id,
                nama: item.nama,
                isLoading: false,
                message: null
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
            createUnitKerja(submission)
                .then(res => {
                    this.isFormModalActive = false;
                    this.formModalProps.isLoading = false;
                    this.snackbar(`Berhasil menambahkan data ${res.data.nama}`, 'is-success');
                })
                .catch(err => {
                    this.formModalProps.isLoading = false;
                    const message = err.response.data.error.message;
                    this.formModalProps.message = `Gagal menambahkan data ${submission.nama}. ${message}`;
                });
            this.applyFilter();
        },
        onSubmitUpdate(submission) {
            this.formModalProps.isLoading = true;
            updateUnitKerja(submission.id, submission)
                .then(res => {
                    this.isFormModalActive = false;
                    this.formModalProps.isLoading = false;
                    this.snackbar(`Berhasil mengubah data ${res.data.nama}`, 'is-success');
                })
                .catch(err => {
                    this.formModalProps.isLoading = false;
                    const message = err.response.data.error.message;
                    this.formModalProps.message = `Gagal mengubah data ${submission.nama}. ${message}`;
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
            deleteUnitKerja(submission.id)
                .then(res => {
                    this.isDeleteModalActive = false;
                    this.deleteModalProps.isLoading = false;
                    this.snackbar(`Berhasil menghapus data ${submission.nama}`, 'is-success');
                })
                .catch(err => {
                    this.deleteModalProps.isLoading = false;
                    const message = err.response.data.error.message;
                    this.deleteModalProps.message = `Gagal menghapus data ${submission.nama}. ${message}`;
                });
            this.applyFilter();
        }
    },
    mounted() {
        this.applyFilter();
    }
}
</script>
