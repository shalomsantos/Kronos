<template>
    <DefaultLayout v-model="viewOption" :title="'Projetos lista'" :location="location">
        <v-card class="mb-3">
            <v-card-item>
                <v-btn
                    @click.prevent="dialogNewProjeto = true"
                    class="text-none"
                    color="green-darken-1"
                    >Novo</v-btn
                >
            </v-card-item>
        </v-card>
        <v-sheet class="bg-transparent">
            <v-row class="bg-transparent" v-if="dados.length > 0 && viewOption">
                <v-col cols="3" v-for="(item, id) in dados" :key="id">
                    <v-hover>
                        <template v-slot:default="{ isHovering, props }">
                            <v-card
                                :title="item.nome"
                                :subtitle="item.tipo_projeto.nome"
                                @click.prevent="EditProjeto(item)"
                                v-bind="props"
                                :color="isHovering ? 'green-lighten-5' : undefined"
                            >
                            <template v-slot:prepend>
                                <v-icon icon="mdi-clipboard-file" color="green-darken-1"></v-icon>
                            </template>
                        </v-card>
                        </template>
                    </v-hover>
                </v-col>
            </v-row>
            <v-table density="compact" v-else-if="dados.length > 0 && !viewOption" striped="even">
                <thead>
                    <tr>
                        <th class="text-left">Nome</th>
                        <th class="text-left">Tipo</th>
                        <th class="text-left">***</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, id) in dados" :key="id" @click.prevent="EditProjeto(item)">
                        <td>{{ item.nome }}</td>
                        <td>{{ item.tipo_projeto.nome }}</td>
                        <td>
                            <v-btn
                                class="text-none me-1"
                                icon="mdi-delete"
                                density="comfortable"
                                color="red-lighten-2"
                            ></v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
            <EmptyData v-else />
        </v-sheet>

        <!-- Dialogs -->
        <v-dialog v-model="dialogEditProjeto" max-width="500">
            <v-toolbar title="Novo projeto" density="compact"
                ><v-btn
                    icon="mdi-close"
                    @click.prevent="dialogEditProjeto = false"
                ></v-btn
            ></v-toolbar>
            <v-card rounded="0">
                <v-card-item class="ma-0 pa-2">
                    <v-row class="pa-4">
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
                        <v-btn class="text-none" color="green-darken-1"
                            >Atualizar</v-btn
                        >
                    </v-row>
                </v-card-item>
            </v-card>
        </v-dialog>

        <NovoProjeto v-model="dialogNewProjeto" @endProcess="carregandoTodosProjetos()"></NovoProjeto>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import NovoProjeto from "@/Components/Dialogs/NovoProjeto.vue";
import EmptyData from "@/Components/EmptyData.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

onMounted(() => {
    carregandoTodosProjetos();
    carregandoTodosTiposProjetos();
});

// Context Var
const location = [
    { title: "Base Zero", disabled: false, href: "/" },
    { title: "Projetos", disabled: true },
    { title: "Lista", disabled: true },
];

const user = usePage().props.auth.user;
const viewOption = ref(user?.preferencia?.listagem_menu ?? 0);
const dados = ref([]);
// form inputs
const inputProjeto = ref(null);
const inputDescricao = ref(null);
// options
const valueTipoProjetos = ref(null);
const itensTipoProjetos = ref([]);

// Dialogs var
const dialogNewProjeto = ref(false);
const dialogEditProjeto = ref(false);
// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

// Functions
async function carregandoTodosProjetos() {
    await axios
        .get(route("projeto.index"), {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            dados.value = res.data;
        })
        .catch((err) => console.log(err));
}
async function carregandoTodosTiposProjetos() {
    await axios
        .get(route("tipoprojeto.index"))
        .then((res) => {
            itensTipoProjetos.value = reducingContent(res.data.data);
        })
        .catch((err) => console.log(err));
}
function EditProjeto(line) {
    inputProjeto.value = line.nome;
    valueTipoProjetos.value = line.tipo_projeto_id;
    inputDescricao.value = line.descricao;

    dialogEditProjeto.value = true;
}
function reducingContent(data) {
    return data.map((item) => ({
        id: item.id,
        label: item.nome || item.label || "",
    }));
}
</script>

<style scoped>
tbody tr:hover {
    background-color: #eeeeee;
}
</style>
