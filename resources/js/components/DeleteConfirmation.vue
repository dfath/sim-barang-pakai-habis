<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Delete Confirmation</p>
        </header>
        <section class="modal-card-body">

            <b-message type="is-warning" has-icon>
                Anda yakin akan menghapus data {{ nama }}. Aksi hapus yang sudah dilakukan tidak dapat dibatalkan.
            </b-message>

        </section>
        <footer class="modal-card-foot">
            <b-button type="is-dark" @click="$parent.close()">Batal</b-button>
            <b-button type="is-primary" @click="onClickButton" :disabled="isLoading" :loading="isLoading" >Ya, Hapus</b-button>
        </footer>
    </div>
</template>

<script>
export default {
    props: {
        id: Number,
        isLoading: Boolean,
        nama: String
    },
    computed: {
        submission() {
            return {
                id: this.id,
                nama: this.nama
            }
        }
    },
    methods: {
        onClickButton() {
            this.$emit('confirmed', this.submission);
        }
    }
};
</script>
