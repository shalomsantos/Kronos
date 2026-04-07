<template>
    <DefaultLayout
        v-model="viewOption"
        :title="'Projetos lista'"
        :location="location"
    >
        <v-sheet class="d-flex ga-3 mb-3" color="transparent">
            <v-btn
                @click.prevent="dialogNewProjeto = true"
                class="text-none"
                color="green-darken-1"
                prepend-icon="mdi-plus"
                text="Adicionar"
            />
            <v-text-field
                v-model="search"
                placeholder="Pesquisar aqui..."
                variant="outlined"
                density="compact"
                hide-details="auto"
                clearable
            />
        </v-sheet>

        <v-sheet class="bg-transparent">
            <!-- CARD -->
            <v-row class="bg-transparent" v-if="dados.length > 0 && viewOption">
                <v-col cols="6" v-for="(item, id) in dados" :key="id">
                    <v-hover>
                        <template v-slot:default="{ isHovering, props }">
                            <v-card
                                v-bind="props"
                                :title="item.nome"
                                prepend-icon="mdi-clipboard-file"
                                @click.prevent="
                                    ((projetoSelecionado = item),
                                    (dialogEditProjeto = true))
                                "
                                :color="
                                    isHovering ? 'green-lighten-5' : undefined
                                "
                            >
                                <template #subtitle>
                                    <v-chip
                                        size="small"
                                        color="green"
                                    >
                                        {{ item.tipo_projeto.nome }}
                                    </v-chip>
                                </template>
                                <template #item>
                                    <p class="text-body-2 text-disabled">
                                        Criado em:
                                        {{ isDate(item.created_at) }}
                                    </p>
                                    <p class="text-body-2 text-disabled">
                                        Por: {{ item.created_by.name }}
                                    </p>
                                </template>
                            </v-card>
                        </template>
                    </v-hover>
                </v-col>
            </v-row>
            <!-- TABLE -->
            <v-table
                class="bg-green-lighten-5"
                density="compact"
                v-else-if="dados.length > 0 && !viewOption"
                striped="even"
            >
                <thead>
                    <tr>
                        <th class="text-left">Nome</th>
                        <th class="text-left">Tipo</th>
                        <th class="text-left">Criado em</th>
                        <th class="text-left">Criado por</th>
                        <th class="text-left">***</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, id) in dados"
                        :key="id"
                        @click.prevent="
                            ((projetoSelecionado = item),
                            (dialogEditProjeto = true))
                        "
                    >
                        <td>{{ item.nome }}</td>
                        <td>{{ item.tipo_projeto.nome }}</td>
                        <td>{{ isDate(item.created_at) }}</td>
                        <td>
                            <v-chip size="x-small" color="green" variant="flat">
                                {{ item.created_by.name }}
                            </v-chip>
                        </td>
                        <td>
                            <v-btn
                                disabled
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
        <EditeProjeto
            v-model="dialogEditProjeto"
            :projeto="projetoSelecionado"
            :tipos="tiposProjetos"
            @closeEditProjeto="
                ((projetoSelecionado = null), (dialogEditProjeto = false))
            "
            @editeProcess="editProjeto"
        />
        <NovoProjeto
            v-model="dialogNewProjeto"
            @insertProcess="insertProjeto"
        ></NovoProjeto>
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EditeProjeto from "@/Components/Dialogs/Projeto/EditeProjeto.vue";
import NovoProjeto from "@/Components/Dialogs/Projeto/NovoProjeto.vue";
import EmptyData from "@/Components/EmptyData.vue";
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { ref } from "vue";
import axios from "axios";
// dados trazidos com a rota.
const props = defineProps({
    projetos: {
        type: Object,
        required: true,
    },
    tiposProjetos: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
    preferencias: {
        type: Object,
        required: true,
    },
});
// Content var
const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Projetos", disabled: true },
    { title: "Lista", disabled: true },
];
// const user = props.user;
const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const dados = ref(props.projetos ?? []);
// Seleção
const projetoSelecionado = ref(null);
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
async function insertProjeto(projeto) {
    await axios
        .post(route("projeto.store"), projeto)
        .then((res) => {
            if (res.data.success) {
                carregandoTodosProjetos();

                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "success",
                    text: res.data.message,
                };
            }
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: res.data.message,
            };
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
async function editProjeto(projeto) {
    const projectId = projeto.id;

    await axios
        .patch(route("projeto.update", projectId), projeto)
        .then((res) => {
            if (!res.data.success) {
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "error",
                    text: res.data.message,
                };
                return;
            }

            carregandoTodosProjetos();
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "success",
                text: res.data.message,
            };
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
</script>

<style scoped>
.position-absolute {
    bottom: 0;
    right: 0;
}
</style>
