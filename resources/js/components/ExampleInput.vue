<template>
    <b-field label="Example Input">
        <b-input name="example" v-model="example"></b-input>
    </b-field>
</template>

<script>
export default {
    data() {
        return {
            example: ""
        }
    }
}
</script>
