<template>
    <v-dialog v-model="model" max-width="500">
        <v-toolbar title="Novo tipo de projeto" density="compact"
            ><v-btn
                icon="mdi-close"
                size="small"
                @click.prevent="
                    (model=false), (tipoProjetoNome = null)
                "
            ></v-btn
        ></v-toolbar>
        <v-card rounded="0">
            <v-card-item class="ma-0 pa-2">
                <v-row class="pa-2">
                    <v-col>
                        <v-text-field
                            v-model="tipoProjetoNome"
                            label="Digite aqui o tipo de projeto"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-btn
                            class="text-none"
                            color="green-darken-1"
                            size="large"
                            prepend-icon="mdi-content-save"
                            @click.prevent="insertEvent"
                            >Salvar</v-btn
                        >
                    </v-col>
                </v-row>
            </v-card-item>
        </v-card>
        <NormalFeedback v-model="feedback" />
    </v-dialog>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { ref } from "vue";

const model = defineModel();

const emit = defineEmits(['insertProcess'])

const tipoProjetoNome = ref(null);
// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});
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
    emit('insertProcess', tipoProjeto);
}
</script>

<style scoped></style>
