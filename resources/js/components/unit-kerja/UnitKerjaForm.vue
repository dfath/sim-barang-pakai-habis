<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Unit Kerja</p>
        </header>
        <section class="modal-card-body">

            <b-field label="Nama">
                <b-input
                    :value="nama"
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
            nama: null,
            isLoading: false
        }
    }
}
</script>
