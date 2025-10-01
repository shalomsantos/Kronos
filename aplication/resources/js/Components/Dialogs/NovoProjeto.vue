<template>
    <div>
        <v-dialog v-model="model" max-width="500">
            <v-toolbar title="Novo projeto" density="compact"
                ><v-btn icon="mdi-close" @click.prevent="(model = false, inputProjeto=null, valueTipoProjetos=null,inputDescricao=null)"></v-btn
            ></v-toolbar>
            <v-card rounded="0">
                <v-card-item class="ma-0 pa-2">
                    <v-row dense class="pa-4">
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
                                @click.prevent="dialogNewTipoProjeto = true"
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
                                @click.prevent="insertProjeto"
                                >Salvar</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-card-item>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogNewTipoProjeto" max-width="500">
            <v-toolbar title="Novo tipo de projeto" density="compact"
                ><v-btn
                    icon="mdi-close"
                    @click.prevent="(dialogNewTipoProjeto = false, tipoProjetoNome = null)"
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
                                @click.prevent="insertTipoProjeto"
                                >Salvar</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-card-item>
            </v-card>
        </v-dialog>
        <NormalFeedback v-model="feedback" />
    </div>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { ref, onMounted } from "vue";

const model = defineModel();
const emit = defineEmits(['endProcess'])

onMounted(() => {
    carregandoTodosTiposProjetos();
});

// Components var
const inputProjeto = ref(null);
const inputDescricao = ref(null);
const tipoProjetoNome = ref(null);
const valueTipoProjetos = ref(null);
const itensTipoProjetos = ref([]);

// Dialog var
const dialogNewTipoProjeto = ref(false);

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
        .get(route("tipoprojeto.index"))
        .then((res) => {
            if (res.data.success) {
                itensTipoProjetos.value = reducingContent(res.data.data);
            } else {
                feedback.value = {
                    show: true,
                    timeout: 2000,
                    color: "error",
                    text: "Falha no load dos tipos de projeto.",
                };
            }
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
async function insertProjeto() {
    if (inputProjeto.value == null || valueTipoProjetos.value == null) {
        feedback.value = {
            show: true,
            timeout: 4000,
            color: "warning",
            text: "O nome e tipo do projeto devem ser preenchidos.",
        };
        return;
    }
    let data = {
        nome: inputProjeto.value,
        tipo_projeto_id: valueTipoProjetos.value,
        descricao: inputDescricao.value,
    };
    await axios
        .post(route("projeto.store"), data)
        .then((res) => {
            if (res.data.success) {
                emit('endProcess');
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "success",
                    text: res.data.message,
                };
                model.value=false;
            } else {
                model.value=false;
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "error",
                    text: res.data.message,
                };
            }
        })
        .catch((err) => {
            model.value=false;
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: "Axios: " + err + ". Data: " + res.data.message + ".",
            };
        });
}
async function insertTipoProjeto() {
    if (tipoProjetoNome.value.replace(/\s+/g, "") == "")
        alert("É necessario inserir um nome.");

    await axios
        .post(route("tipoprojeto.store"), { nome: tipoProjetoNome.value })
        .then((res) => {
            if (res.data.success) {
                itensTipoProjetos.value = [];
                carregandoTodosTiposProjetos();
                dialogNewTipoProjeto.value = false;

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
                    color: "warning",
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
