<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Barang Masuk</p>
        </header>
        <section class="modal-card-body">
            <b-field label="Kelompok Kegiatan">
                <b-input
                    :value="kelompok_kegiatan_id"
                    required>
                </b-input>
            </b-field>

            <b-field label="Kelompok Kegiatan">
                <b-input
                    :value="kelompok_barang_id"
                    required>
                </b-input>
            </b-field>

        </section>
        <footer class="modal-card-foot">
            <button class="button" type="button" @click="$parent.close()">Close</button>
            <button class="button is-primary">Submit</button>
        </footer>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: null,
            kelompok_kegiatan_id: null,
            kelompok_barang_id: null,
            perusahaan_id: null,
            tahun_anggaran: null,
            tanggal_perolehan: null,
            jenis_bukti: null,
            bukti_transaksi: null,
            isLoading: false
        }
    }
}
</script>
