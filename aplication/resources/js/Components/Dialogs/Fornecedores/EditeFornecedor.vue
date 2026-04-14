<template>
    <Dialog
        v-model="model"
        title="Editar fornecedor"
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
import { ref, watch } from "vue";

const model = defineModel();

const props = defineProps({
    fornecedor: Object,
});
const fornecedorId = ref(null);
const inputFornecedorRazaoSocial = ref("");

watch(
    () => props.fornecedor,
    (novo) => {
        if (novo) {
            fornecedorId.value = props.fornecedor?.id;
            inputFornecedorRazaoSocial.value = props.fornecedor?.razao_social;
        }
    },
    { immediate: true },
);
</script>

<style lang="scss" scoped></style>
