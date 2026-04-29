<template>
    <Dialog
        v-model="model"
        width="60vw"
        title="Editar ou vincular subitens a este item?"
        @onCloseDialog="$emit('closeEvent')"
    >
        <v-row>
            <v-col cols="6">
                <v-text-field label="teste" />
            </v-col>
            <v-col cols="6">
                <v-text-field label="teste" />
            </v-col>
            <v-col cols="6">
                <v-text-field label="teste" />
            </v-col>
            <v-col cols="12">
                <v-btn class="w-auto">entrar</v-btn>
            </v-col>
        </v-row>
    </Dialog>
</template>

<script setup>
import Dialog from "../Dialog.vue";

const model = defineModel();
</script>

<style scoped></style>
