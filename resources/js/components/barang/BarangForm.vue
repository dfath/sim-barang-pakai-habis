<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Barang</p>
        </header>
        <section class="modal-card-body">

            <b-message v-if="message" type="is-warning">
                {{ message }}
            </b-message>

            <b-field label="Kelompok Kegiatan">
                <b-select placeholder="Pilih kelompok kegiatan" v-model="submission.kelompok_kegiatan_id" required>
                    <option
                        v-for="option in kelompokKegiatanCollection"
                        :value="option.id"
                        :key="option.id">
                        {{ option.nama }}
                    </option>
                </b-select>
            </b-field>

            <b-field label="Kelompok Barang">
                <b-select placeholder="Pilih kelompok barang" v-model="submission.kelompok_barang_id" required>
                    <option
                        v-for="option in kelompokBarangCollection"
                        :value="option.id"
                        :key="option.id">
                        {{ option.nama }}
                    </option>
                </b-select>
            </b-field>

            <b-field label="Nama">
                <b-input
                    v-model="submission.nama"
                    required>
                </b-input>
            </b-field>

            <b-field label="Satuan">
                <b-select placeholder="Pilih satuan" v-model="submission.satuan_id" required>
                    <option
                        v-for="option in satuanCollection"
                        :value="option.id"
                        :key="option.id">
                        {{ option.nama }}
                    </option>
                </b-select>
            </b-field>

        </section>
        <footer class="modal-card-foot">
            <b-button @click="$parent.close()">Batal</b-button>
            <b-button type="is-info" @click="onClickButton" :disabled="isLoading" :loading="isLoading" >{{ submitButtonLabel }}</b-button>
        </footer>
    </div>
</template>

<script>
export default {
    props: {
        id: Number,
        nama: String,
        kelompokKegiatanId: Number,
        kelompokKegiatanCollection: Array,
        kelompokBarangId: Number,
        kelompokBarangCollection: Array,
        satuanId: Number,
        satuanCollection: Array,
        isLoading: Boolean,
        message: String
    },
    data() {
        return {
            submission: {
                id: this.id,
                nama: this.nama,
                kelompok_kegiatan_id: this.kelompokKegiatanId,
                kelompok_barang_id: this.kelompokBarangId,
                satuan_id: this.satuanId,
            }
        };
    },
    computed: {
        isCreateAction() {
            return this.id === null;
        },
        submitButtonLabel() {
            return this.isCreateAction ? 'Tambah' : 'Ubah';
        }
    },
    methods: {
        onClickButton() {
            this.$emit('submitted', this.submission);
        }
    }
};
</script>
