<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Satuan</p>
        </header>
        <section class="modal-card-body">

            <b-message v-if="message" type="is-warning">
                {{ message }}
            </b-message>

            <b-field label="Nama">
                <b-input
                    v-model="submission.nama"
                    required>
                </b-input>
            </b-field>

            <b-field label="Pimpinan">
                <b-input
                    v-model="submission.pimpinan"
                    required>
                </b-input>
            </b-field>

            <b-field label="Alamat">
                <b-input
                    v-model="submission.alamat"
                    type="textarea"
                    required>
                </b-input>
            </b-field>

        </section>
        <footer class="modal-card-foot">
            <b-button type="is-info" @click="onClickButton" :disabled="isLoading" :loading="isLoading" >{{ submitButtonLabel }}</b-button>
        </footer>
    </div>
</template>

<script>
export default {
    props: {
        id: Number,
        nama: String,
        pimpinan: String,
        alamat: String,
        isLoading: Boolean,
        message: String
    },
    data() {
        return {
            submission: {
                id: this.id,
                nama: this.nama,
                pimpinan: this.pimpinan,
                alamat: this.alamat
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
