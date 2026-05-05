<template>
    <Dialog
        v-model="model"
        width="30vw"
        title="Novo Subitem"
        @onCloseDialog="((model = false), (inputSubitemNome = null))"
    >
        <v-row>
            <v-col>
                <v-text-field
                    v-model="inputSubitemNome"
                    label="Nome*"
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
import { ref } from "vue";
import Dialog from "../Dialog.vue";
import { useFeedback } from "@/Composables/useFeedback";

const model = defineModel();

const { trigger } = useFeedback();
const emit = defineEmits(["insertProcess"]);

const inputSubitemNome = ref(null);

function insertEvent() {
    if (inputSubitemNome.value == null) {
        trigger('O campo nome é obrigatório.', 'warning')
        return 
    }
    let tipoProjeto = {
        nome: inputSubitemNome.value,
    };
    cleanAll()
    emit("insertProcess", tipoProjeto);
}

function cleanAll(){ inputSubitemNome.value = null; model.value = false; }
</script>

<style scoped></style>
