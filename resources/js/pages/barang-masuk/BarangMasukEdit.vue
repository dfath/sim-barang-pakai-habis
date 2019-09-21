<template>
    <div class="container is-fluid">
        <br/>
        <div class="columns">

            <div class="column is-three-quarters">
                <barang-masuk-form
                    v-if="barangMasuk.tahunAnggaran"
                    v-bind="barangMasuk"
                    :perusahaanCollection="reference.perusahaanCollection"
                    :kelompokKegiatanCollection="reference.kelompokKegiatanCollection"
                    :kelompokBarangCollection="reference.kelompokBarangCollection"
                    :isModal=false
                    v-on:submitted="onBarangMasukSubmitted">
                </barang-masuk-form>
            </div>

        </div>
    </div>
</template>

<script>
import { readPerusahaanCollection, readKelompokKegiatanCollection, readKelompokBarangCollection, readBarangMasukCollection, updateBarangMasuk, readBarangMasuk } from '../../network/api';
import BarangMasukForm from '../../components/barang-masuk/BarangMasukForm';
import { years } from '../../utils';

export default {
    components: {
        BarangMasukForm,
    },
    props: {
        id: Number
    },
    data() {
        return {
            barangMasuk: {
                id: this.id,
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
            barangMasukDetil: {
                isLoading: false
            },
            reference: {
                kelompokKegiatanCollection: [],
                kelompokBarangCollection: [],
                perusahaanCollection: [],
            },
            years: years()
        }
    },
    computed: {
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
        loadBarangMasuk() {
            this.barangMasuk.isLoading = true;
            readBarangMasuk(this.barangMasuk.id)
                .then(res => {

                    this.barangMasuk.id = res.data.id;
                    this.barangMasuk.perusahaanId = res.data.perusahaan_id;
                    this.barangMasuk.kelompokKegiatanId = res.data.kelompok_kegiatan_id;
                    this.barangMasuk.kelompokBarangId = res.data.kelompok_barang_id;
                    this.barangMasuk.tahunAnggaran = res.data.tahun_anggaran;
                    this.barangMasuk.tanggalPerolehan = new Date(res.data.tanggal_perolehan);
                    this.barangMasuk.jenisBukti = res.data.jenis_bukti;
                    this.barangMasuk.buktiTransaksi = res.data.bukti_transaksi;

                })
                .catch(err => {
                    throw err;
                })
                .finally(() => {
                    this.barangMasuk.isLoading = false;
                });
        },
        onBarangMasukSubmitted(submission) {
            this.barangMasuk.isLoading = true;
            updateBarangMasuk(submission.id, submission)
                .then(res => {
                    this.$buefy.notification.open({
                        message: `Berhasil mengubah data ${res.data.bukti_transaksi}`,
                        type: 'is-success'
                    });
                })
                .catch(err => {
                    const message = err.response.data.error.message;
                    this.barangMasuk.message = `Gagal mengubah data ${submission.bukti_transaksi}. ${message}`;
                })
                .finally(() => {
                    this.barangMasuk.isLoading = false;
                });
        }
    },
    mounted() {
        this.loadReference();
        this.loadBarangMasuk();
    }
}
</script>
