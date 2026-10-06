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
                            @keydown.enter.prevent="carregarDados(search)"
                            @click:clear="carregarDados('')"
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
            <v-row dense>
                <v-col v-if="carregando"
                    cols="12"
                    class="d-flex justify-center align-center py-10"
                >
                    <v-progress-circular
                        indeterminate
                        color="green-darken-1"
                        size="64"
                    />
                </v-col>
                <template v-else>
                    <v-col cols="12">
                        <EmptyData v-if="!dados.data?.length" />
                        <ViewMode v-else :mode="viewOption">
                            <template #table>
                                <ProjectTable
                                    :items="dados.data"
                                    @editar="abrirEdicao"
                                />
                            </template>
                            <template #cards>
                                <ProjectCards
                                    :items="dados.data"
                                    @editar="abrirEdicao"
                                />
                            </template>
                        </ViewMode>
                    </v-col>
                </template>
            </v-row>
            <v-col cols="12" class="d-flex justify-center">
                <v-pagination
                    v-model="dados.current_page"
                    :length="dados.last_page"
                    :total-visible="4"
                    @update:model-value="updatePage"
                    active-color="green-darken-4"
                    color="green-lighten-1"
                    class="position-absolute bottom-0 mb-3"
                    style="left: 50%; transform: translateX(-50%); z-index: 15"
                    density="comfortable"
                    variant="flat"
                ></v-pagination>
            </v-col>
        </v-row>

        <EditeProjeto
            v-model="dialogEditProjeto"
            :projeto="projetoSelecionado"
            :tipos="tiposProjetos"
            @closeEditProjeto="(projetoSelecionado = null)"
            @editeProcess="editProjeto"
        />
        <NovoProjeto
            v-model="dialogNewProjeto"
            @end="endInsert"
        />
    </DefaultLayout>
</template>

<script setup>
import ViewMode from "@/Components/Shared/ViewMode.vue";
import ProjectTable from "@/Components/Cadastros/Project/ProjectTable.vue";
import ProjectCards from "@/Components/Cadastros/Project/ProjectCards.vue";
import EditeProjeto from "@/Components/Dialogs/Projeto/EditeProjeto.vue";
import NovoProjeto from "@/Components/Dialogs/Projeto/NovoProjeto.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { useFeedback } from "@/Composables/useFeedback";
import { useProjeto } from "@/Composables/useProjeto";
import EmptyData from "@/Components/EmptyData.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import axios from "axios";

const props = defineProps({
    projetos:      Object,
    tiposProjetos: Object,
    user:          Object,
    preferencias:  Object
});
const location = [
    { title: "Kronos", href: "/" },
    { title: "Projetos" },
    { title: "Lista", disabled: false },
];
const { trigger }           = useFeedback();
const { carregando, index } = useProjeto();
const dados                 = ref(props.projetos);
const viewOption            = ref(Number(props.preferencias?.listagem_menu ?? 0));
const projetoSelecionado    = ref(null);
const search                = ref("");
// dialogs
const dialogNewProjeto      = ref(false);
const dialogEditProjeto     = ref(false);
// functions
const updatePage = (page) => {
    router.get(
        route("projeto.index"),
        { page: page },
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: (page) => {
                dados.value = page.props.projetos;
            },
        },
    );
};
async function endInsert(message) {
    dialogNewProjeto.value = false
    trigger(message, 'success')
    const res = await index();
    dados.value = res.data || res.data.data;
}
async function carregarDados(termo = "") {
   try {
        const res = await index(termo);
        dados.value = res.data;
    } catch (err) {
        trigger(err.response?.data?.message || "Erro ao carregar", 'error');
    }
}
async function editProjeto(projeto) {
    const projectId = projeto.id;

    await axios
        .patch(route("projeto.update", projectId), projeto)
        .then((res) => {
            if (!res.data.success) {
                trigger(res.data.message, "error")
                return;
            }
            carregarDados();
            trigger(res.data.message, "success")
        })
        .catch((err) => {
            trigger(err, "error")
        });
}
function abrirEdicao(item) {
    projetoSelecionado.value = item;
    dialogEditProjeto.value = true;
}
</script>

<style scoped></style>
