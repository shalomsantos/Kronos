<template>
    <DefaultLayout
        v-model="viewOption"
        :title="'Bases Lista'"
        :location="location"
    >
        <v-sheet class="d-flex ga-3 mb-3" color="transparent">
            <v-btn
                class="text-none"
                prepend-icon="mdi-filter"
                color="green-darken-1"
                text="Filtro"
                @click="dialogFilter = !dialogFilter"
            />
            <v-btn
                class="text-none"
                prepend-icon="mdi-plus"
                color="green-darken-1"
                text="Adicionar"
                @click="dialogNewBasezero = !dialogNewBasezero"
            />
        </v-sheet>

        <ViewOptionMode v-model="viewOption" :dados="dados" />

        <!-- Dialogs -->
        <FiltroBase v-model="dialogFilter" @onFilter="filtrarBases" />

        <v-dialog v-model="dialogNewBasezero" max-width="650">
            <v-toolbar title="Nova Base zero" density="compact"
                ><v-btn
                    icon="mdi-close"
                    size="small"
                    @click.prevent="
                        ((dialogNewBasezero = false), endingProcess())
                    "
                ></v-btn
            ></v-toolbar>
            <v-card rounded="0">
                <v-card-item class="ma-0 pa-2">
                    <v-row class="pa-2">
                        <v-col cols="9" class="d-flex ga-2 align-center">
                            <v-select
                                v-model="projetosValue"
                                clearable
                                label="Projetos"
                                :items="projetosOptions"
                                item-title="label"
                                item-value="id"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                            ></v-select>
                            <v-btn
                                class="text-none"
                                :href="route('projeto.index')"
                                prepend-icon="mdi-plus"
                                color="green-darken-1"
                                >Projeto</v-btn
                            >
                        </v-col>
                        <v-col cols="3">
                            <v-text-field
                                v-model="ano"
                                label="Ano"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea
                                v-model="inputDescricao"
                                label="Descrição"
                                variant="outlined"
                                density="compact"
                                clearable
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
                                @click.prevent="insertBzero"
                                >Salvar</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-card-item>
            </v-card>
        </v-dialog>
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import FiltroBase from "@/Components/Dialogs/Bzero/FiltroBase.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";
import ViewOptionMode from "@/Components/Bases/ViewOptionMode.vue";

// <===> Context Var <===>
const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Lista", disabled: true },
];
const user = usePage().props.auth.user;
const viewOption = ref(user?.preferencia?.listagem_menu ?? 0);
const dados = ref([]);
// <===> Form and Options <===>
const projetosValue = ref(null);
const projetosOptions = ref([]);
const ano = ref(null);
const inputDescricao = ref(null);

// <===> Default Load Page <===>
onMounted(() => {
    carregandoTodosProjetos();
    carregandoTodosBases();
});

// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

// <===> Dialogs <===>
const dialogFilter = ref(false);
const dialogNewBasezero = ref(false);

// <===> Functions <===>
async function carregandoTodosBases() {
    await axios
        .get(route("bzero.index"), {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            dados.value = res.data;
        })
        .catch((err) => console.log(err));
}
async function carregandoTodosProjetos() {
    await axios
        .get(route("projeto.index"), {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            projetosOptions.value = reducingContent(res.data);
        })
        .catch((err) => console.log(err));
}
async function insertBzero() {
    if (projetosValue.value == null || ano.value == null) {
        alert(
            "Certifique-se de que os campos projeto e ano estão preenchidos.",
        );
        return;
    }

    let data = {
        projeto_id: projetosValue.value,
        ano: ano.value,
        descricao: inputDescricao.value,
    };
    await axios
        .post(route("bzero.store"), data)
        .then((res) => {
            if (res.data.success) {
                carregandoTodosBases();
                endingProcess();
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "success",
                    text: res.data.message,
                };
            } else {
                endingProcess();
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "error",
                    text: res.data.message ?? res.data,
                };
            }
        })
        .catch((err) => {
            endingProcess();
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: err,
            };
        });
}
function reducingContent(data) {
    return data.map((item) => ({
        id: item.id,
        label: item.nome || item.label || "",
    }));
}
function endingProcess() {
    carregandoTodosBases();
    projetosValue.value = null;
    ano.value = null;
    inputDescricao.value = null;

    dialogNewBasezero.value = false;
}
async function filtrarBases(filtros) {
    await axios
        .post(route("bzero.filtro"), filtros)
        .then((res) => {
            dados.value = res.data.data ?? [];
            dialogFilter.value = false;
        })
        .catch((err) => console.log(err));
}
</script>

<style scoped>
.position-absolute {
    bottom: 0;
    right: 0;
}
</style>
