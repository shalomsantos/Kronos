<template>
    <div>
        <v-dialog v-model="model" max-width="500">
            <v-toolbar title="Novo projeto" density="compact"
                ><v-btn
                    icon="mdi-close"
                    size="small"
                    @click.prevent="
                        (model = false),
                            (inputProjeto = null),
                            (valueTipoProjetos = null),
                            (inputDescricao = null)
                    "
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
                            <v-btn
                                class="text-none"
                                prepend-icon="mdi-plus"
                                color="green-darken-1"
                                @click.prevent="dialogNovoTipoProjeto = true"
                                >Tipo</v-btn
                            >
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
                                prepend-icon="mdi-content-save"
                                @click.prevent="insertEvent"
                                >Salvar</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-card-item>
            </v-card>
        </v-dialog>
        <!-- Dialog -->
        <NovoTipoProjeto
            v-model="dialogNovoTipoProjeto"
            max-width="500"
            @insertProcess="insertTipoProjeto"
        />
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </div>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import NovoTipoProjeto from "./NovoTipoProjeto.vue";
import { ref, onMounted } from "vue";

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
