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
                        <b-input v-model="filterNamaUnitKerja"></b-input>
                    </p>
                    <p class="control">
                    <b-button class="button is-info" @click="applyFilter">Cari</b-button>
                    </p>
                </div>
                </div>
            </div>

            <!-- Right side -->
            <div class="level-right">
                <p class="level-item"><b-button type="is-success" @click="openFormModal()">Tambah</b-button></p>
            </div>
        </div>

        <div class="columns">
            <div class="column">

                <div class="table-container">
                    <b-table
                        :data="unitKerjaData"

                        striped
                        :paginated="unitKerjaTotal > 0"
                        backend-pagination
                        :loading="isLoading"
                        :total="unitKerjaTotal"
                        :per-page="unitKerjaPerPage"
                        @page-change="onPageChange"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">

                        <b-notification v-if="!isLoading" :closable=false slot="empty">
                            Data tidak ditemukan.
                        </b-notification>

                        <template slot-scope="props">
                            <b-table-column field="nama" label="Nama">
                                {{ props.row.nama }}
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
import { fetchListUnitKerja } from '../../network/api';
import UnitKerjaForm from '../../components/unit-kerja/UnitKerjaForm';

export default {
    components: {
        UnitKerjaForm,
    },
    data() {
        return {
            filterNamaUnitKerja: null,
            filterPage: 1,
            unitKerjaData: [],
            unitKerjaMeta: {
                total: null,
                per_page: null,
                current_page: null
            },
            isLoading: false
        }
    },
    computed: {
        unitKerjaTotal() {
            return this.unitKerjaMeta.total;
        },
        unitKerjaPerPage() {
            return this.unitKerjaMeta.per_page;
        },
        unitKerjaCurrentPage() {
            return this.unitKerjaMeta.current_page;
        },
        params() {
            return {
                nama: this.filterNamaUnitKerja,
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
            fetchListUnitKerja(this.params)
                .then(res => {
                    this.unitKerjaData = res.data;
                    this.unitKerjaMeta = res.meta;
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
                component: UnitKerjaForm,
                hasModalCard: true,
                canCancel: false,
            })
        }
    },
    mounted() {
        this.applyFilter();
    }
}
</script>
