<template>
    <DefaultLayout v-model="viewOption" title="Subitens" :location="location">
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
                            @click:clear="carregandoTodasSubitens('')"
                        />
                    </v-col>
                    <v-col align="end">
                        <v-btn
                            class="text-none"
                            color="green-darken-1"
                            prepend-icon="mdi-plus"
                            text="Novo subitem"
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
                            prepend-icon="mdi-sitemap"
                            :color="
                                isHovering
                                    ? 'green-lighten-5'
                                    : undefined
                            "
                            @click.prevent="
                                ((subitemSelecionado = item),
                                (dialogEditSubitem = true))
                            "
                        >
                            <template #subtitle>
                                <p class="text-body-2 text-disabled">
                                    Criado em:
                                    {{ isDate(item.created_at) }}
                                </p>
                                <p class="text-body-2 text-disabled">
                                    Por: {{ item.created_by.name }}
                                </p>
                            </template>
                            <template #item>
                                <v-sheet
                                    class="d-flex flex-wrap ga-2 bg-transparent pt-3"
                                >
                                    <v-chip
                                        size="x-small"
                                        color="green"
                                        variant="flat"
                                        v-for="(
                                            fornecedor, id
                                        ) in item.fornecedores"
                                        :key="id"
                                    >
                                        {{ fornecedor.razao_social }}
                                    </v-chip>
                                </v-sheet>
                            </template>
                        </v-card>
                    </template>
                </v-hover>
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
                            <th class="text-left">Subitens</th>
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
                                ((subitemSelecionado = item),
                                (dialogEditSubitem = true))
                            "
                        >
                            <td>{{ item.nome }}</td>
                            <td>
                                <v-chip
                                    v-for="(fornecedor, idx) in item.fornecedores.slice(0, 2)"
                                    :key="idx"
                                    size="x-small"
                                    color="green-darken-1"
                                    variant="tonal"
                                    class="font-weight-bold"
                                >
                                    {{ fornecedor.razao_social }}
                                </v-chip>
                                <v-chip
                                    v-if="item.fornecedores.length > 2"
                                    size="x-small"
                                    variant="text"
                                    class="text-grey-darken-1"
                                >
                                    +{{ item.fornecedores.length - 2 }} itens
                                </v-chip>
                            </td>
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
                                    density="comfortable"
                                    color="red-lighten-2"
                                    @click.prevent="confirmation = true"
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
        <EditeSubitem
            v-model="dialogEditSubitem"
            :subitem="subitemSelecionado"
            @onCloseDialog="
                ((subitemSelecionado = null), (dialogEditSubitem = false))
            "
        />
        <v-dialog v-model="confirmation" max-width="500">
            <v-toolbar
                title="Confirmar operação?"
                density="compact"
            ></v-toolbar>
            <v-card rounded="0" title="Lorem ipsum">
                <v-card-item>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                </v-card-item>
                <v-card-actions>
                    <v-btn
                        size="small"
                        text="Confirmar"
                        color="success"
                        @click.prevent="confirmation = false"
                    />
                    <v-spacer></v-spacer>
                    <v-btn
                        size="small"
                        text="cancelar"
                        color="red"
                        @click.prevent="confirmation = false"
                    />
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </DefaultLayout>
</template>

<script setup>
import EditeSubitem from "@/Components/Dialogs/Subitens/EditeSubitem.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    subitens: Object,
    user: Object,
    preferencias: Object,
});

const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Subitem", disabled: true },
    { title: "Lista", disabled: true },
];

const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const dados = ref(props.subitens ?? []);
const subitemSelecionado = ref(null);
const confirmation = ref(false);
const search = ref("");
// dialog
const dialogEditSubitem = ref(false);

// Feedback
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});
async function insertSubitem(item) {}

const carregandoFornecedores = async () => {
    await axios
        .get(route("fornecedor.index"))
        .then((res) => {
            optionsFornecedor.value = res.data.data;
        })
        .catch((err) => console.error(err));
};
function executarBusca() {
    carregandoTodasSubitens(search.value);
}
async function carregandoTodasSubitens(termo = "") {
    await axios
        .get(route("subitem.index"), {
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
