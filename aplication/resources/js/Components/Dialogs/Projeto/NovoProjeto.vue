<template>
    <Dialog
        v-model="model"
        width="40vw"
        title="Novo projeto"
        @onCloseDialog="
            ((model = false),
            (inputProjeto = null),
            (valueTipoProjetos = null),
            (inputDescricao = null))
        "
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
                <v-combobox
                    v-model="valueTipoProjetos"
                    :items="itensTipoProjetos"
                    item-title="label"
                    item-value="id"
                    :return-object="false"
                    label="Escolher ou inserir tipo projeto"
                    variant="outlined"
                    density="compact"
                    color="green-darken-3"
                    hide-details
                    clearable
                >
                    <template v-slot:prepend-item>
                        <v-divider></v-divider>
                        <v-list-item
                            title="Não encontrou?"
                            subtitle="Clique para cadastrar um novo"
                            prepend-icon="mdi-plus-circle-outline"
                            color="primary"
                            @click.prevent="dialogNovoTipoProjeto = true"
                        >
                        </v-list-item>
                        <v-divider></v-divider>
                    </template>

                    <template v-slot:no-data>
                        <v-list-item
                            title="Nenhum item encontrado"
                            subtitle="Clique aqui para criar um novo"
                            @click.prevent="dialogNovoTipoProjeto = true"
                        ></v-list-item>
                    </template>
                </v-combobox>
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
                    counter
                ></v-textarea>
            </v-col>
            <v-col cols="12" class="pt-3">
                <v-btn
                    class="text-none"
                    color="green-darken-1"
                    prepend-icon="mdi-clipboard-check"
                    text="Salvar"
                    @click.prevent="insertEvent"
                />
            </v-col>
        </v-row>

        <NovoTipoProjeto
            v-model="dialogNovoTipoProjeto"
            width="40vw"
            @insertProcess="insertTipoProjeto"
        />
    </Dialog>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import NovoTipoProjeto from "./NovoTipoProjeto.vue";
import { ref, onMounted } from "vue";
import Dialog from "../Dialog.vue";

const model = defineModel();

const props = defineProps({
    tipos: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["insertProcess"]);

onMounted(() => {
    carregandoTodosTiposProjetos();
});

// Components var
const inputProjeto = ref(null);
const inputDescricao = ref(null);

const valueTipoProjetos = ref(null);
const itensTipoProjetos = ref(props.tipos ? reducingContent(props.tipos) : []);

// Dialog var
const dialogNovoTipoProjeto = ref(false);

// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

// Functions
async function carregandoTodosTiposProjetos() {
    await axios
        .get(route("tipoprojeto.index"), {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            itensTipoProjetos.value = reducingContent(res.data);
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: err,
            };
        });
}
function insertEvent() {
    if (inputProjeto.value == null || valueTipoProjetos.value == null) {
        feedback.value = {
            show: true,
            timeout: 4000,
            color: "warning",
            text: "O nome e tipo do projeto devem ser preenchidos.",
        };
        return;
    }

    let projeto = {
        nome: inputProjeto.value,
        tipo_projeto_id: valueTipoProjetos.value,
        descricao: inputDescricao.value,
    };
    // limpando inputs
    inputProjeto.value = null;
    valueTipoProjetos.value = null;
    inputDescricao.value = null;
    // fechando dialog
    model.value = false;
    // emitindo evento para o pai
    emit("insertProcess", projeto);
}
async function insertTipoProjeto(tipoProjeto) {
    await axios
        .post(route("tipoprojeto.store"), { nome: tipoProjeto.nome })
        .then((res) => {
            if (res.data.success) {
                // reload tipos de projetos
                itensTipoProjetos.value = [];
                carregandoTodosTiposProjetos();
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "success",
                    text: res.data.message,
                };
            } else {
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "error",
                    text: res.data.message,
                };
            }
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: "Axios: " + err + ". Data: " + res.data.message + ".",
            };
        });
}
function reducingContent(data) {
    return data.map((item) => ({
        id: item.id,
        label: item.nome || item.label || "",
    }));
}
</script>

<style scoped></style>
