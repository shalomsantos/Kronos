<template>
    <DefaultLayout
        v-model="viewOption"
        title="Projetos"
        :location="location"
    >
        <v-row dense>
            <v-col cols="12">
                <v-row>
                    <v-col cols="4">
                        <v-text-field
                            v-model="search"
                            placeholder="Aperte a tecla enter para buscar..."
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            color="green-darken-3"
                            clearable
                            append-inner-icon="mdi-magnify"
                            @keydown.enter="executarBusca"
                            @click:clear="carregandoTodosProjetos('')" 
                        />
                    </v-col>
                    <v-col align="end">
                        <v-btn
                            @click.prevent="dialogNewProjeto = true"
                            class="text-none"
                            color="green-darken-1"
                            prepend-icon="mdi-clipboard-plus"
                            text="Novo projeto"
                        />
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="6" v-if="dados.length > 0 && viewOption" v-for="(item, id) in dados" :key="id">
                <v-hover>
                    <template v-slot:default="{ isHovering, props }">
                        <v-card
                            v-bind="props"
                            :title="item.nome"
                            prepend-icon="mdi-clipboard"
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
            <v-col cols="12" v-else-if="dados.length > 0 && !viewOption">
                <v-table
                    class="rounded-lg elevation-3"
                    density="compact"
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
            </v-col>                
            <v-col cols="12" v-else>
                <EmptyData />
            </v-col>                
        </v-row>

        <!-- Dialogs -->
        <EditeProjeto
            v-model="dialogEditProjeto"
            :projeto="projetoSelecionado"
            :tipos="tiposProjetos"
            @closeEditProjeto="((projetoSelecionado = null), (dialogEditProjeto = false))"
            @editeProcess="editProjeto"
        />
        <NovoProjeto
            v-model="dialogNewProjeto"
            @insertProcess="insertProjeto"
        />
    </DefaultLayout>
</template>

<script setup>
import EditeProjeto from "@/Components/Dialogs/Projeto/EditeProjeto.vue";
import NovoProjeto from "@/Components/Dialogs/Projeto/NovoProjeto.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { useFeedback } from "@/Composables/useFeedback";
import EmptyData from "@/Components/EmptyData.vue";
import { ref } from "vue";
import axios from "axios";

const props = defineProps({
    projetos: Object,
    tiposProjetos: Object,
    user: Object,
    preferencias: Object
});
const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Projetos", disabled: true },
    { title: "Lista", disabled: true },
];
const { trigger } = useFeedback();

const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const dados = ref(props.projetos ?? []);
const projetoSelecionado = ref(null);
const search = ref("");
// dialogs
const dialogNewProjeto = ref(false);
const dialogEditProjeto = ref(false);
// functions
async function insertProjeto(projeto) {
    await axios
        .post(route("projeto.store"), projeto)
        .then((res) => {
            if (res.data.success) {
                carregandoTodosProjetos();
                trigger(res.data.message, 'success')
                return;
            }
            trigger(res.data.message, 'error')
        })
        .catch((err) => trigger(err, 'error'));
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
function executarBusca() {
    carregandoTodosProjetos(search.value);
}
async function carregandoTodosProjetos(termo = "") {
    await axios
        .get(route("projeto.index"), {
            params: { search: termo },
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            dados.value =  res.data; 
        })
        .catch((err) => trigger(err, 'error'));
}
</script>

<style scoped></style>
