<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Barang Masuk Detil</p>
        </header>
        <section class="modal-card-body">

            <b-message v-if="message" type="is-warning">
                {{ message }}
            </b-message>

            <b-field label="Barang">
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
                            {{ props.option.nama_barang }}
                        </div>
                    </template>

                    <template slot="empty">No results found</template>
                </b-autocomplete>
            </b-field>

            <b-field label="Volume">
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
import { readVolumeDpaCollection } from '../../network/api';

export default {
    props: {
        id: Number,
        barangMasukId: Number,
        volumeDpaId: Number,
        volume: Number,
        tahunAnggaran: Number,
        kelompokBarangId: Number,
        kelompokKegiatanId: Number,
        namaBarang: String,
        isLoading: Boolean,
        message: String
    },
    data() {
        return {
            isFetching: false,
            labelBarang: this.namaBarang,
            barangCollection: [],
            submission: {
                id: this.id,
                barang_masuk_id: this.barangMasukId,
                volume_dpa_id: this.volumeDpaId,
                volume: this.volume
            },
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
        },
        fetchBarang(nama) {
            this.isFetching = true;
            const filter = {
                nama_barang: nama,
                kelompok_barang_id: this.kelompokBarangId,
                kelompok_kegiatan_id: this.kelompokKegiatanId,
                tahun_anggaran: this.tahunAnggaran,
            };
            console.log(filter);
            readVolumeDpaCollection(filter)
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
                this.labelBarang = option.nama_barang;
                this.submission.volume_dpa_id = option.id;
            }
        }
    }
};
</script>
