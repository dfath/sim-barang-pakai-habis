<template>
    <div class="container is-fluid">
        <br/>

        <div class="columns is-multiline">
            <div class="column is-half">
                <form class="forms">
                    <div class="form-container">

                        <b-field label="Unit Kerja">
                            <b-select expanded placeholder="Pilih unit kerja" v-model="filter.unitKerjaId">
                                <option
                                    v-for="option in reference.unitKerjaCollection"
                                    :value="option.id"
                                    :key="option.id">
                                    {{ option.nama }}
                                </option>
                            </b-select>
                        </b-field>

                        <b-field label="Kelompok Kegiatan">
                            <b-select expanded placeholder="Pilih kelompok kegiatan" v-model="filter.kelompokKegiatanId">
                                <option
                                    v-for="option in reference.kelompokKegiatanCollection"
                                    :value="option.id"
                                    :key="option.id">
                                    {{ option.nama }}
                                </option>
                            </b-select>
                        </b-field>

                        <b-field label="Kelompok Barang">
                            <b-select expanded placeholder="Pilih kelompok barang" v-model="filter.kelompokBarangId">
                                <option
                                    v-for="option in reference.kelompokBarangCollection"
                                    :value="option.id"
                                    :key="option.id">
                                    {{ option.nama }}
                                </option>
                            </b-select>
                        </b-field>

                        <b-field label="Tanggal Perolehan">
                            <b-datepicker
                                placeholder="Click to select..."
                                v-model="filter.tanggalKeluar"
                                range>
                            </b-datepicker>
                        </b-field>

                        <div class="field">
                            <div class="control">
                                <b-button class="button is-link" @click="applyFilter">Tampilkan</b-button>
                                <a class="button is-link" target="__blank" :href="filterQs('/barang-keluar/cetak')">Cetak</a>
                                <a class="button is-link" target="__blank" :href="filterQs('/barang-keluar/ekspor')">Ekspor</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="column is-full">

                <section>

                    <b-table
                        :data="tableData"

                        striped
                        :loading="filter.isLoading">

                        <b-notification v-if="!filter.isLoading" :closable=false slot="empty">
                            Data tidak ditemukan.
                        </b-notification>

                        <template slot-scope="props">

                            <b-table-column field="no" label="No">
                                {{ props.row.no }}
                            </b-table-column>

                            <b-table-column field="nama_barang" label="Nama Barang">
                                {{ props.row.nama_barang }}
                            </b-table-column>

                            <b-table-column numeric field="sisa" label="Sisa">
                                {{ props.row.sisa }}
                            </b-table-column>

                            <b-table-column numeric field="total_volume" label="Jumlah Barang Keluar">
                                {{ props.row.total_volume }}
                            </b-table-column>

                            <b-table-column numeric field="total_harga" label="Nilai (Jumlah barang * harga satuan)">
                                {{ currency( props.row.total_harga ) }}
                            </b-table-column>

                        </template>

                    </b-table>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import qs from 'qs';
import { readUnitKerjaCollection, laporanBarangKeluar, readKelompokKegiatanCollection, readKelompokBarangCollection } from '../../network/api';
import { formatNumber } from '../../utils';

export default {
    data() {
        return {
            filter: {
                unitKerjaId: null,
                kelompokBarangId: null,
                kelompokKegiatanId: null,
                tanggalKeluar: [
                    new Date(new Date().getFullYear(), 0, 1),
                    new Date()
                ],
                isLoading: false
            },
            reference: {
                kelompokKegiatanCollection: [],
                kelompokBarangCollection: [],
                unitKerjaCollection: [],
            },
            tableData: []
        }
    },
    computed: {
        filterParams() {
            return {
                unit_kerja_id: this.filter.unitKerjaId,
                kelompok_kegiatan_id: this.filter.kelompokKegiatanId,
                kelompok_barang_id: this.filter.kelompokBarangId,
                tanggal_mulai: this.filter.tanggalKeluar[0].toISOString().split('T')[0],
                tanggal_selesai: this.filter.tanggalKeluar[1].toISOString().split('T')[0]
            }
        },
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
        applyFilter() {
            this.filter.isLoading = true;
            laporanBarangKeluar(this.filterParams)
                .then(res => {
                    this.tableData = res.data;
                })
                .catch(err => {
                    throw err;
                })
                .finally(() => {
                    this.filter.isLoading = false;
                });
        },
        currency(num) {
            return formatNumber(num);
        },
        filterQs(baseUrl) {
            return `${baseUrl}?${qs.stringify(this.filterParams)}`;
        }
    },
    mounted() {
        this.loadReference();
        this.applyFilter();
    }
}
</script>
