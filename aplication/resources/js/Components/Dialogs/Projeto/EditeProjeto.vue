<template>
    <Dialog
        v-model="model"
        title="Editar Projeto"
        width="40vw"
        @onCloseDialog="((model=false), ($emit('closeEditProjeto')))"
    >
        <v-row>
            <v-col cols="12">
                <v-text-field
                    v-model="inputProjeto"
                    label="Nome*"
                    variant="outlined"
                    density="compact"
                    color="green-darken-3"
                    hide-details
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
                    color="green-darken-3"
                    hide-details
                ></v-select>
            </v-col>
            <v-col cols="12">
                <v-textarea
                    v-model="inputDescricao"
                    clearable
                    label="Descrição"
                    variant="outlined"
                    density="compact"
                    color="green-darken-3"
                    :counter="255"
                    maxlength="255"
                    rows="3"
                    auto-grow
                ></v-textarea>
            </v-col>
            <v-col cols="12" class="pt-3">
                <v-btn
                    class="text-none"
                    color="green-darken-1"
                    prepend-icon="mdi-pencil"
                    text="Editar"
                    @click.prevent="editEvent()"
                />
            </v-col>
        </v-row>
    </Dialog>
</template>

<script setup>
import { useFeedback } from "@/Composables/useFeedback";
import Dialog from "../Dialog.vue";
import { ref, watch } from "vue";

const model = defineModel();

const props = defineProps({
    projeto: Object, 
    tipos: Object,
});

const { trigger } = useFeedback();
const emit = defineEmits(['editeProcess', 'closeEditProjeto']);
// form inputs
const inputProjeto = ref(props.projeto?.nome);
const inputDescricao = ref(props.projeto?.descricao);
// options
const valueTipoProjetos = ref(props.projeto?.tipo_projeto_id);
const itensTipoProjetos = ref(props.tipos ? reducingContent(props.tipos) : []);

watch(
    () => props.projeto,
    (newProjeto) => {
        if (newProjeto) {
            inputProjeto.value = newProjeto.nome;
            inputDescricao.value = newProjeto.descricao;
            valueTipoProjetos.value = newProjeto.tipo_projeto_id;
        }
    },
    { deep: true, immediate: true },
);

function editEvent() {
    if (!inputProjeto.value || !valueTipoProjetos.value) {
        trigger('Por favor, preencha todos os campos obrigatórios.', 'error');
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
