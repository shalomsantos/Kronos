<template>
    <Dialog
        v-model="model"
        title="Novo fornecedor"
        width="60vw"
        @onCloseDialog="$emit('onCloseDialog')"
    >
        <v-row dense>
            <v-col>
                <v-text-field
                    v-model="inputFornecedorRazaoSocial"
                    label="razão social"
                />
            </v-col>
        </v-row>
    </Dialog>
</template>

<script setup>
import Dialog from "../Dialog.vue";
import { ref } from "vue";

const model = defineModel();

const inputFornecedorRazaoSocial = ref("");
</script>

<style lang="scss" scoped></style>
