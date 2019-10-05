<template>
    <div :class="{ 'modal-card' : isModal, 'card' : !isModal }" style="width: auto">
        <header :class="{ 'modal-card-head' : isModal, 'card-header' : !isModal }">
            <p :class="{ 'modal-card-title' : isModal, 'card-header-title' : !isModal }">Barang Masuk</p>
        </header>
        <section :class="{ 'modal-card-body' : isModal, 'card-content' : !isModal }">

            <b-message v-if="message" type="is-warning">
                {{ message }}
            </b-message>

            <b-field horizontal label="Tahun Anggaran">
                <b-select expanded placeholder="Pilih tahun anggaran" v-model="submission.tahun_anggaran" required>
                    <option
                        v-for="option in years"
                        :value="option"
                        :key="option">
                        {{ option }}
                    </option>
                </b-select>
            </b-field>

            <b-field horizontal label="Kelompok Kegiatan">
                <b-select expanded placeholder="Pilih kelompok kegiatan" v-model="submission.kelompok_kegiatan_id" required>
                    <option
                        v-for="option in kelompokKegiatanCollection"
                        :value="option.id"
                        :key="option.id">
                        {{ option.nama }}
                    </option>
                </b-select>
            </b-field>

            <b-field horizontal label="Kelompok Barang">
                <b-select expanded placeholder="Pilih kelompok barang" v-model="submission.kelompok_barang_id" required>
                    <option
                        v-for="option in kelompokBarangCollection"
                        :value="option.id"
                        :key="option.id">
                        {{ option.nama }}
                    </option>
                </b-select>
            </b-field>

            <b-field horizontal label="Perusahaan">
                <b-select expanded placeholder="Pilih perusahaan" v-model="submission.perusahaan_id" required>
                    <option
                        v-for="option in perusahaanCollection"
                        :value="option.id"
                        :key="option.id">
                        {{ option.nama }}
                    </option>
                </b-select>
            </b-field>

            <b-field horizontal label="Jenis Bukti">
                <b-select expanded placeholder="Pilih bukti transaksi" v-model="submission.jenis_bukti" required>
                    <option
                        v-for="option in jenisBuktiTransaksi"
                        :value="option"
                        :key="option">
                        {{ option }}
                    </option>
                </b-select>
            </b-field>

            <b-field horizontal label="Bukti Transaksi">
                <b-input
                    v-model="submission.bukti_transaksi"
                    required>
                </b-input>
            </b-field>

            <b-field horizontal label="Tanggal perolehan">
                <b-datepicker
                    placeholder="Pilih tanggal perolehan"
                    v-model="submission.tanggal_perolehan"
                    icon="calendar-today"
                    required>
                </b-datepicker>
            </b-field>

        </section>
        <footer class="modal-card-foot">
            <b-button type="is-info" @click="onClickButton" :disabled="isLoading" :loading="isLoading" >{{ submitButtonLabel }}</b-button>
        </footer>
    </div>
</template>

<script>
import { years, jenisBuktiTransaksi } from '../../utils';

export default {
    props: {
        id: Number,
        kelompokKegiatanId: Number,
        kelompokKegiatanCollection: Array,
        kelompokBarangId: Number,
        kelompokBarangCollection: Array,
        perusahaanId: Number,
        perusahaanCollection: Array,
        tahunAnggaran: Number,
        tanggalPerolehan: Date,
        jenisBukti: String,
        buktiTransaksi: String,
        isLoading: Boolean,
        message: String,
        isModal: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            submission: {
                id: this.id,
                kelompok_kegiatan_id: this.kelompokKegiatanId,
                kelompok_barang_id: this.kelompokBarangId,
                perusahaan_id: this.perusahaanId,
                tahun_anggaran: this.tahunAnggaran,
                tanggal_perolehan: this.tanggalPerolehan,
                jenis_bukti: this.jenisBukti,
                bukti_transaksi: this.buktiTransaksi,
            },
            years: years(),
            jenisBuktiTransaksi: jenisBuktiTransaksi()
        }
    },
    computed: {
        isCreateAction() {
            return this.id === null;
        },
        submitButtonLabel() {
            return this.isCreateAction ? 'Tambah' : 'Ubah';
        },
        finalSubmission() {
            const tanggal = new Date(this.submission.tanggal_perolehan);
            const date = {
                tanggal_perolehan: `${tanggal.getFullYear()}-${tanggal.getMonth() + 1}-${tanggal.getDate()}`,
            };
            return {...this.submission, ...date};
        },
    },
    methods: {
        onClickButton() {
            this.$emit('submitted', this.finalSubmission);
        }
    }
}
</script>
