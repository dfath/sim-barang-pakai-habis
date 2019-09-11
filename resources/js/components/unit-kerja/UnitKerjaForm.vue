<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Unit Kerja</p>
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

        </section>
        <footer class="modal-card-foot">
            <b-button type="is-dark" @click="$parent.close()">Close</b-button>
            <b-button type="is-primary" @click="onClickButton" :disabled="isLoading" :loading="isLoading" >Submit</b-button>
        </footer>
    </div>
</template>

<script>
export default {
    props: {
        id: Number,
        nama: String,
        isLoading: Boolean,
        message: String
    },
    data() {
        return {
            submission: {
                id: this.id,
                nama: this.nama
            }
        };
    },
    methods: {
        onClickButton() {
            this.$emit('submitted', this.submission);
        }
    }
};
</script>
