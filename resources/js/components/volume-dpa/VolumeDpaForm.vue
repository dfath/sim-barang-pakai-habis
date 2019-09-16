<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Volume DPA</p>
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
                            {{ props.option.nama }}
                        </div>
                    </template>

                    <template slot="empty">No results found</template>
                </b-autocomplete>
            </b-field>

            <b-field label="Tahun Anggaran">
                <b-select placeholder="Pilih tahun anggaran" v-model="submission.tahun_anggaran" required>
                    <option
                        v-for="option in years"
                        :value="option"
                        :key="option">
                        {{ option }}
                    </option>
                </b-select>
            </b-field>

            <b-field label="Volume">
                <b-numberinput
                    v-model="submission.volume"
                    min=0
                    required>
                </b-numberinput>
            </b-field>

            <b-field label="Harga satuan">
                <b-numberinput
                    v-model="submission.harga_satuan"
                    min=0
                    step=1000
                    required>
                </b-numberinput>
            </b-field>

        </section>
        <footer class="modal-card-foot">
            <b-button @click="$parent.close()">Batal</b-button>
            <b-button type="is-info" @click="onClickButton" :disabled="isLoading" :loading="isLoading" >{{ submitButtonLabel }}</b-button>
        </footer>
    </div>
</template>

<script>
import { readBarangCollection } from '../../network/api';
import {years} from '../../utils';

export default {
    props: {
        id: Number,
        barangId: Number,
        namaBarang: String,
        tahunAnggaran: Number,
        volume: Number,
        hargaSatuan: Number,
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
                barang_id: this.barangId,
                tahun_anggaran: this.tahunAnggaran,
                volume: this.volume,
                harga_satuan: this.hargaSatuan,
            },
            years: years(2018),
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
            readBarangCollection({nama:nama})
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
            this.labelBarang = option.nama;
            this.submission.barang_id = option.id;
        }
    }
};
</script>
