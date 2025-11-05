<template>
    <v-dialog v-model="model" max-width="500">
        <v-toolbar title="Atualizar projeto" density="compact"
            ><v-btn
                icon="mdi-close"
                size="small"
                @click.prevent="$emit('closeEditProjeto')"
            ></v-btn
        ></v-toolbar>
        <v-card rounded="0">
            <v-card-item class="ma-0 pa-2">
                <v-row class="pa-2">
                    <v-col cols="12">
                        <v-text-field
                            v-model="inputProjeto"
                            label="Nome*"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" class="d-flex ga-2 align-center">
                        <v-select
                            v-model="valueTipoProjetos"
                            label="Tipo do projeto*"
                            :items="itensTipoProjetos"
                            item-title="label"
                            item-value="id"
                            clearable
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                        ></v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-textarea
                            v-model="inputDescricao"
                            clearable
                            label="Descrição"
                            variant="outlined"
                            density="compact"
                            hide-details
                            rows="2"
                            auto-grow
                            counter
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12" class="pt-3">
                        <v-btn
                            class="text-none"
                            color="green-darken-1"
                            size="large"
                            prepend-icon="mdi-update"
                            @click.prevent="editEvent()"
                            >Atualizar</v-btn
                        >
                    </v-col>
                </v-row>
            </v-card-item>
        </v-card>

        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </v-dialog>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { ref, watch } from "vue";

const model = defineModel();

const props = defineProps({
    projeto: {
        type: Object,
        required: true,
    },
    tipos: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["editeProcess"]);

// form inputs
const inputProjeto = ref(props.projeto?.nome);
const inputDescricao = ref(props.projeto?.descricao);
// options
const valueTipoProjetos = ref(props.projeto?.tipo_projeto_id);
const itensTipoProjetos = ref(props.tipos ? reducingContent(props.tipos) : []);

// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

watch(() => props.projeto, (newProjeto) => {
    if (newProjeto) {
        inputProjeto.value = newProjeto.nome;
        inputDescricao.value = newProjeto.descricao;
        valueTipoProjetos.value = newProjeto.tipo_projeto_id;
    }
}, { deep: true, immediate: true });

function editEvent() {
    if (!inputProjeto.value || !valueTipoProjetos.value) {
        feedback.value = {
            show: true,
            timeout: 2000,
            color: "error",
            text: "Por favor, preencha todos os campos obrigatórios.",
        };
        return;
    }
    const projeto = {
        id: props.projeto.id,
        nome: inputProjeto.value,
        descricao: inputDescricao.value,
        tipo_projeto_id: valueTipoProjetos.value,
    };
    inputProjeto.value = null;
    inputDescricao.value = null;
    valueTipoProjetos.value = null;
    model.value = false;
    emit("editeProcess", projeto);
}

function reducingContent(data) {
    return data.map((item) => ({
        id: item.id,
        label: item.nome || item.label || "",
    }));
}
</script>

<style scoped></style>
