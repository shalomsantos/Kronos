<template>
    <DefaultLayout
        v-model="viewOption"
        title="Plataformas"
        :location="location"
    >
        <v-row dense>
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
                    @click:clear="carregandoTodasPlataformas('')"
                />
            </v-col>
            <v-col align="end">
                <v-btn
                    @click.prevent="dialogNovaPlataforma = true"
                    class="text-none"
                    color="green-darken-1"
                    prepend-icon="mdi-layers-plus"
                    text="Nova plataforma"
                />
            </v-col>
            <v-col cols="12" v-if="dados.length > 0 && viewOption">
                <v-row>
                    <v-col cols="6" v-for="(item, id) in dados" :key="id">
                        <v-hover>
                            <template v-slot:default="{ isHovering, props }">
                                <v-card
                                    v-bind="props"
                                    :title="item.nome"
                                    prepend-icon="mdi-layers"
                                    @click.prevent="
                                        ((plataformaSelecionada = item),
                                        (dialogEditePlataforma = true))
                                    "
                                    :color="isHovering ? 'green-lighten-5' : undefined"
                                >
                                    <template #subtitle>
                                        <v-row no-gutters>
                                            <v-col cols="2">
                                                <p class="text-body-2 text-disabled">
                                                    Criado em:
                                                    {{ isDate(item.created_at) }}
                                                </p>
                                                <p class="text-body-2 text-disabled">
                                                    Por: {{ item.created_by.name }}
                                                </p>
                                            </v-col>
                                        </v-row>
                                    </template>
                                    <template #item>
                                        <v-sheet
                                            class="d-flex flex-wrap ga-2 bg-transparent pt-3"
                                        >
                                            <v-chip
                                                size="x-small"
                                                color="green"
                                                variant="flat"
                                                v-for="(item1, id) in item.itens"
                                                :key="id"
                                            >
                                                {{ item1.nome }}
                                            </v-chip>
                                        </v-sheet>
                                    </template>
                                </v-card>
                            </template>
                        </v-hover>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" v-else-if="dados.length > 0 && !viewOption">
                <v-table
                    class="bg-green-lighten-5"
                    density="compact"
                    striped="even"
                >
                    <thead>
                        <tr>
                            <th class="text-left">Nome</th>
                            <th class="text-left">Criado em</th>
                            <th class="text-left">Criado por</th>
                            <th class="text-left">***</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, id) in dados"
                            :key="id"
                            @click.prevent="editePlataforma(item)"
                        >
                            <td>{{ item.nome }}</td>
                            <td>{{ isDate(item.created_at) }}</td>
                            <td>
                                <v-chip
                                    size="x-small"
                                    color="green"
                                    variant="flat"
                                >
                                    {{ item.created_by?.name }}
                                </v-chip>
                            </td>
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
            </v-col>
            <v-col cols="12" v-else>
                <EmptyData />
            </v-col>
        </v-row>
        <!-- Dialogs -->
        <EditePlataforma
            v-model="dialogEditePlataforma"
            :plataforma="plataformaSelecionada"
            @onCloseDialog="
                ((plataformaSelecionada = null),
                (dialogEditePlataforma = false))
            "
        />
        <NovaPlataforma
            v-model="dialogNovaPlataforma"
            @onCloseDialog="((dialogNovaPlataforma = false))"
            @insertProcess="insertPlataforma"
        />
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </DefaultLayout>
</template>

<script setup>
import EditePlataforma from "@/Components/Dialogs/Plataforma/EditePlataforma.vue";
import NovaPlataforma from "@/Components/Dialogs/Plataforma/NovaPlataforma.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import { ref } from "vue";
import axios from "axios";
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";

const props = defineProps({
    plataformas: Object,
    user: Object,
    preferencias: Object,
});

const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Plataformas", disabled: true },
    { title: "Lista", disabled: true },
];

const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const dados = ref(props.plataformas ?? []);
const plataformaSelecionada = ref(null);
const search = ref("");
// dialogs
const dialogEditePlataforma = ref(false);
const dialogNovaPlataforma = ref(false);
// Feedback
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});
// functions
async function insertPlataforma(plataforma) {
    await axios
        .post(route("plataforma.store"), plataforma)
        .then((res) => {
            if (res.data.success) {
                carregandoTodasPlataformas();
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "success",
                    text: res.data.message,
                };
                return;
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
function executarBusca() {
    carregandoTodasPlataformas(search.value);
}
async function carregandoTodasPlataformas(termo = "") {
    await axios
        .get(route("plataforma.index"), {
            params: { search: termo },
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            dados.value = res.data;
        })
        .catch((err) => console.log(err));
}
</script>

<style scoped></style>
