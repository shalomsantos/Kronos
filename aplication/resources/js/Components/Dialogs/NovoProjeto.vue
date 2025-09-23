<template>
    <div>
        <v-dialog v-model="model" max-width="500">
            <v-toolbar title="Novo projeto" density="compact"
                ><v-btn icon="mdi-close" @click.prevent="model = false"></v-btn
            ></v-toolbar>
            <v-card rounded="0">
                <v-card-item class="ma-0 pa-2">
                    <v-row class="pa-4">
                        <v-col cols="12">
                            <v-text-field
                                label="Nome"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="d-flex ga-2 align-center">
                            <v-select
                                v-model="valueTipoProjetos"
                                clearable
                                label="Tipo do projeto"
                                :items="itensTipoProjetos"
                                item-title="label"
                                item-value="id"
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
                        <v-btn class="text-none" color="green-darken-1"
                            >Salvar</v-btn
                        >
                    </v-row>
                </v-card-item>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogNewTipoProjeto" max-width="500">
            <v-toolbar title="Nova tipo de projeto" density="compact"
                ><v-btn
                    icon="mdi-close"
                    @click.prevent="dialogNewTipoProjeto = false"
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

onMounted(() => {
    loadAllTypes();
});

// Components var
const tipoProjetoNome = ref("");
const valueTipoProjetos = ref();
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
async function loadAllTypes() {
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
                    text: "Falha no load dos tipos de projeto."
                };
            }
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: err
            };
        });
}
async function insertTipoProjeto() {
    if (tipoProjetoNome.value.replace(/\s+/g, "") == "") alert("É necessario inserir um nome.");

    await axios
        .post(route("tipoprojeto.store"), { nome: tipoProjetoNome.value })
        .then((res) => {
            if (res.data.success) {
                feedback.value = {
                    show: true,
                    timeout: 2000,
                    text: res.data.message
                };
            } else {
                feedback.value = {
                    show: true,
                    timeout: 2000,
                    text: res.data.message
                };
            }
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 2000,
                text: 'Axios: '+err+'. Data: '+res.data.message+'.'
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
