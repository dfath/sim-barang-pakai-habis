<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Barang Keluar</p>
        </header>
        <section class="modal-card-body">

            <b-message v-if="message" type="is-warning">
                {{ message }}
            </b-message>

            <b-field horizontal label="Kelompok Kegiatan">
                <b-select expanded placeholder="Pilih kelompok kegiatan" v-model="metaData.kelompok_kegiatan_id" required>
                    <option
                        v-for="option in kelompokKegiatanCollection"
                        :value="option.id"
                        :key="option.id">
                        {{ option.nama }}
                    </option>
                </b-select>
            </b-field>

            <b-field horizontal label="Kelompok Barang">
                <b-select expanded placeholder="Pilih kelompok barang" v-model="metaData.kelompok_barang_id" required>
                    <option
                        v-for="option in kelompokBarangCollection"
                        :value="option.id"
                        :key="option.id">
                        {{ option.nama }}
                    </option>
                </b-select>
            </b-field>

            <b-field horizontal label="Unit Kerja">
                <b-select expanded placeholder="Pilih unit kerja" v-model="submission.unit_kerja_id" required>
                    <option
                        v-for="option in unitKerjaCollection"
                        :value="option.id"
                        :key="option.id">
                        {{ option.nama }}
                    </option>
                </b-select>
            </b-field>

            <b-field horizontal label="Tanggal">
                <b-datepicker
                    placeholder="Pilih tanggal"
                    v-model="submission.tanggal"
                    icon="calendar-today"
                    required>
                </b-datepicker>
            </b-field>

            <b-field horizontal label="Barang" :message="barangMessage">
                <b-autocomplete
                    :data="barangCollection"
                    placeholder="Ketik nama barang"
                    field="barang_id"
                    :loading="isFetching"
                    :value="labelBarang"
                    @typing="fetchBarang"
                    @select="onSelectBarang">
                    <template slot-scope="props">
                        <div>
                            {{ props.option.nama }}
                        </div>
                    </template>

                    <template slot="empty">No results found</template>
                </b-autocomplete>
            </b-field>

            <b-field horizontal label="Volume">
                <b-numberinput
                    v-model="submission.volume"
                    min=1
                    required>
                </b-numberinput>
            </b-field>

        </section>
        <footer class="modal-card-foot">
            <b-button type="is-info" @click="onClickButton" :disabled="isLoading" :loading="isLoading" >{{ submitButtonLabel }}</b-button>
        </footer>
    </div>
</template>

<script>
import { readStokBarangCollection } from '../../network/api';

export default {
    props: {
        id: Number,
        kelompokKegiatanId: Number,
        kelompokBarangId: Number,
        barangId: Number,
        namaBarang: String,
        unitKerjaId: Number,
        volume: Number,
        tanggal: Date,
        kelompokKegiatanCollection: Array,
        kelompokBarangCollection: Array,
        unitKerjaCollection: Array,
        isLoading: Boolean,
        message: String
    },
    data() {
        return {
            isFetching: false,
            barangMessage: null,
            labelBarang: this.namaBarang,
            barangCollection: [],
            metaData: {
                kelompok_barang_id: this.kelompokBarangId,
                kelompok_kegiatan_id: this.kelompokKegiatanId
            },
            submission: {
                id: this.id,
                barang_id: this.barangId,
                unit_kerja_id: this.unitKerjaId,
                volume: this.volume,
                tanggal: this.tanggal
            }
        };
    },
    computed: {
        isCreateAction() {
            return this.id === null;
        },
        submitButtonLabel() {
            return this.isCreateAction ? 'Tambah' : 'Ubah';
        },
        finalSubmission() {
            const tanggal = new Date(this.submission.tanggal);
            const date = {
                tanggal: `${tanggal.getFullYear()}-${tanggal.getMonth() + 1}-${tanggal.getDate()}`,
            };
            return {...this.submission, ...date};
        },
    },
    methods: {
        onClickButton() {
            this.$emit('submitted', this.finalSubmission);
        },
        fetchBarang(nama) {
            this.isFetching = true;
            const filter = {
                nama_barang: nama,
                kelompok_barang_id: this.metaData.kelompok_barang_id,
                kelompok_kegiatan_id: this.metaData.kelompok_kegiatan_id,
                tanggal: this.submission.tanggal,
            };
            readStokBarangCollection(filter)
                .then(res => {
                    this.barangCollection = res.data;
                })
                .catch(err => {
                    throw err;
                })
                .finally(() => {
                    this.isFetching = false;
                });
        },
        onSelectBarang(option) {
            if(option) {
                this.barangMessage = `Sisa barang sebanyak ${option.stok}`;
                this.labelBarang = option.nama;
                this.submission.barang_id = option.id;
            }
        }
    }
};
</script>
