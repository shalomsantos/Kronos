<template>
    <DefaultLayout
        v-model="viewOption"
        title="Bases Lista"
        :location="location"
    >
        <v-row dense>
            <v-col cols="12" class="d-flex justify-end ga-3 mb-1">
                <v-btn
                    class="text-none"
                    prepend-icon="mdi-filter"
                    color="green-darken-1"
                    text="Filtro"
                    @click="dialogFilter = true"
                />
                <v-btn
                    class="text-none"
                    prepend-icon="mdi-plus"
                    color="green-darken-1"
                    text="Nova base"
                    @click="dialogNewBasezero = true"
                />
            </v-col>
            <v-col cols="6" v-if="dados.data.length > 0 && viewOption" v-for="(item, id) in dados.data" :key="id">
                <v-hover>
                    <template v-slot:default="{ isHovering, props }">
                        <v-card
                            v-bind="props"
                            :color="isHovering ? 'teal-lighten-5' : undefined"
                            @click="exibirDetalhes(item.id)"
                        >
                            <template v-slot:title>
                                <v-btn
                                    variant="outlined"
                                    color="green-darken-1"
                                >
                                    <p class="text-h6 text-green-darken-1">
                                        #{{ item.id }}
                                    </p>
                                    <v-icon
                                        icon="mdi-text-box"
                                        color="green-darken-1"
                                    ></v-icon>
                                </v-btn>
                                {{ item.projeto.nome }}
                            </template>
                            <template v-slot:item>
                                <v-row no-gutters class="pt-2">
                                    <v-col cols="3">
                                        <p class="text-body-2">Status</p>
                                        <div>
                                            <p
                                                class="text-body-2 text-disabled"
                                            >
                                                {{ item.status.nome }}
                                            </p>
                                        </div>
                                    </v-col>
                                    <v-col cols="3">
                                        <p class="text-body-2">Ano</p>
                                        <div>
                                            <p
                                                class="text-body-2 text-disabled"
                                            >
                                                {{ item.ano }}
                                            </p>
                                        </div>
                                    </v-col>
                                    <v-col cols="3">
                                        <p class="text-body-2">Criado em</p>
                                        <div>
                                            <p
                                                class="text-body-2 text-disabled"
                                            >
                                                {{ isDate(item.created_at) }}
                                            </p>
                                        </div>
                                    </v-col>
                                    <v-col cols="3">
                                        <p class="text-body-2">Por</p>
                                        <div>
                                            <p
                                                class="text-body-2 text-disabled"
                                            >
                                                {{ item.created_by.name }}
                                            </p>
                                        </div>
                                    </v-col>
                                    
                                    <v-sheet
                                            class="d-flex flex-wrap ga-2 bg-transparent pt-3"
                                        >
                                            <v-chip
                                                size="x-small"
                                                color="green"
                                                variant="flat"
                                                v-for="plataforma in item.plataformas"
                                                :key="plataforma.id"
                                            >
                                                {{ plataforma.nome }}
                                            </v-chip>
                                        </v-sheet>
                                </v-row>
                            </template>
                        </v-card>
                    </template>
                </v-hover>
            </v-col>
            <v-col cols="12" v-else-if="dados.data.length > 0 && !viewOption">
                <v-table
                    density="compact"
                    class="bg-green-lighten-5"
                    striped="even"
                >
                    <thead>
                        <tr>
                            <th class="text-left">Id</th>
                            <th class="text-left">Projeto</th>
                            <th class="text-left">Status</th>
                            <th class="text-left">Ano</th>
                            <th class="text-left">Criado em</th>
                            <th class="text-left">Criador por</th>
                            <th class="text-left">***</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, id) in dados.data" :key="id" @click="exibirDetalhes(item.id)">
                            <td>{{ item.id }}</td>
                            <td>{{ item.projeto.nome }}</td>
                            <td>{{ item.status.nome }}</td>
                            <td>{{ item.ano }}</td>
                            <td>{{ isDate(item.created_at) }}</td>
                            <td>
                                <v-chip
                                    size="x-small"
                                    color="green"
                                    variant="flat"
                                >
                                    {{ item.created_by.name }}
                                </v-chip>
                            </td>
                            <td>
                                <v-btn
                                    class="text-none me-1"
                                    icon="mdi-delete"
                                    density="compact"
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

        <!-- Dialogs -->
        <FiltroBase v-model="dialogFilter" @onFilter="filtrarBases" />

        <NovaBase v-model="dialogNewBasezero" :projetos="props.projetos" @onCloseDialog="dialogNewBasezero = false"/>
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </DefaultLayout>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import FiltroBase from "@/Components/Dialogs/Bzero/FiltroBase.vue";
import NovaBase from "@/Components/Dialogs/Bzero/NovaBase.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import axios from "axios";

const props = defineProps({
    bzeros: Object,
    projetos: Object,
    preferencias: Object,
});
const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Lista", disabled: true },
];
const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const dados = ref(props.bzeros);
// Dialogs
const dialogFilter = ref(false);
const dialogNewBasezero = ref(false);
// Feedback
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});
// Functions
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
            dados.value = res.data.data || res.data;
            dialogFilter.value = false;
        })
        .catch((err) => console.log(err));
}
function exibirDetalhes(id) {
    router.get(route('bzero.show', id));
}
const updatePage = (page) => {
    router.get(
        route("bzero.index"),
        { page: page },
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: (page) => {
                dados.value = page.props.bzeros;
            },
        },
    );
};
</script>

<style scoped></style>
