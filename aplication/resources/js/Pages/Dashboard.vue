<template>
    <DefaultLayout
        v-model="viewOption"
        :title="'Bases Lista'"
        :location="location"
    >
        <v-sheet
            class="d-flex ga-3 ma-5 position-absolute"
            color="transparent"
            style="z-index: 1"
        >
            <v-btn
                class="text-none"
                icon="mdi-filter"
                color="green-darken-1"
                size="x-large"
                text="Filtro"
                @click="dialogFilter = !dialogFilter"
            />
            <v-btn
                class="text-none"
                icon="mdi-plus"
                size="x-large"
                color="green-darken-1"
                text="Adicionar"
                @click="dialogNewBasezero = !dialogNewBasezero"
            />
        </v-sheet>
        <v-row>
            <v-col
                cols="6"
                v-if="dados.data.length > 0 && viewOption"
                v-for="(item, id) in dados.data"
                :key="id"
            >
                <v-hover>
                    <template v-slot:default="{ isHovering, props }">
                        <v-card
                            v-bind="props"
                            :color="isHovering ? 'teal-lighten-5' : undefined"
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
                                    <v-col cols="4">
                                        <p class="text-body-2">Status</p>
                                        <div>
                                            <p
                                                class="text-body-2 text-disabled"
                                            >
                                                {{ item.status.nome }}
                                            </p>
                                        </div>
                                    </v-col>
                                    <v-col cols="4">
                                        <p class="text-body-2">Ano</p>
                                        <div>
                                            <p
                                                class="text-body-2 text-disabled"
                                            >
                                                {{ item.ano }}
                                            </p>
                                        </div>
                                    </v-col>
                                    <v-col cols="4">
                                        <p class="text-body-2">Criado em</p>
                                        <div>
                                            <p
                                                class="text-body-2 text-disabled"
                                            >
                                                {{ isDate(item.created_at) }}
                                            </p>
                                        </div>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-chip
                                            size="x-small"
                                            color="green"
                                            variant="flat"
                                        >
                                            {{ item.created_by.name }}
                                        </v-chip>
                                    </v-col>
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
                        <tr v-for="(item, id) in dados" :key="id">
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
                    v-model="bzeros.current_page"
                    :length="bzeros.last_page"
                    :total-visible="4"
                    @update:model-value="updatePage"
                    active-color="green-darken-4"
                    color="green-lighten-1"
                    density="comfortable"
                    variant="flat"
                ></v-pagination>
            </v-col>
        </v-row>

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
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import FiltroBase from "@/Components/Dialogs/Bzero/FiltroBase.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { ref, onMounted, computed } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    bzeros: Object,
    user: Object,
    preferencias: Object,
});

const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Lista", disabled: true },
];

const viewOption = ref(props.preferencias?.listagem_menu ?? 0);

const dados = computed(() => props.bzeros);

const projetosValue = ref(null);
const projetosOptions = ref([]);
const ano = ref(null);
const inputDescricao = ref(null);

onMounted(() => {
    carregandoTodosProjetos();
});

// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

// Dialogs
const dialogFilter = ref(false);
const dialogNewBasezero = ref(false);

// Functions
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
            dados.data.value = res.data.data ?? [];
            dialogFilter.value = false;
        })
        .catch((err) => console.log(err));
}
const updatePage = (page) => {
    router.get(
        route("bzero.index"),
        { page: page },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};
</script>

<style scoped>
.position-absolute {
    bottom: 0;
    right: 0;
}
</style>
