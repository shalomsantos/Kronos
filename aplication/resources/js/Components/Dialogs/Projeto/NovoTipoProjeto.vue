<template>
    <Dialog
        v-model="model"
        title="Novo Tipo de Projeto"
        width="40vw"
        @onCloseDialog="((model = false), (tipoProjetoNome = null))"
    >
        <v-row>
            <v-col>
                <v-text-field
                    v-model="tipoProjetoNome"
                    label="Digite aqui o tipo de projeto"
                    variant="outlined"
                    density="compact"
                    color="green-darken-3"
                    hide-details
                    clearable
                ></v-text-field>
            </v-col>
            <v-col cols="12">
                <v-btn
                    class="text-none"
                    color="green-darken-1"
                    prepend-icon="mdi-check"
                    text="Salvar"
                    @click.prevent="insertEvent"
                />
            </v-col>
        </v-row>
    </Dialog>
</template>

<script setup>
import Dialog from "../Dialog.vue";
import { ref } from "vue";

const model = defineModel();

const emit = defineEmits(["insertProcess"]);

const tipoProjetoNome = ref(null);

function insertEvent() {
    if (tipoProjetoNome.value == null) {
        feedback.value = {
            show: true,
            timeout: 4000,
            color: "warning",
            text: "O campo nome é obrigatório.",
        };
        return;
    }
    let tipoProjeto = {
        nome: tipoProjetoNome.value,
    };
    // limpando input
    tipoProjetoNome.value = null;
    // fechando dialog
    model.value = false;
    // emitindo evento para o pai
    emit("insertProcess", tipoProjeto);
}
</script>

<style scoped></style>
