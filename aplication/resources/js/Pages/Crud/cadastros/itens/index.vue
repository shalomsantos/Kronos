<template>
    <DefaultLayout v-model="viewOption" title="Itens" :location="location">
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
                            @click:clear="carregandoTodasItens('')"
                        />
                    </v-col>
                    <v-col align="end">
                        <v-btn
                            @click.prevent="dialogNovoItem = true"
                            class="text-none"
                            color="green-darken-1"
                            prepend-icon="mdi-invoice-text-plus"
                            text="Novo item"
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
                            prepend-icon="mdi-invoice-list"
                            :color="
                                isHovering
                                    ? 'green-lighten-5'
                                    : undefined
                            "
                            @click.prevent="
                                ((itemSelecionado = item),
                                (dialogEditeItem = true))
                            "
                        >
                            <template #subtitle>
                                <v-row no-gutters>
                                    <v-col cols="2">
                                        <p
                                            class="text-body-2 text-disabled"
                                        >
                                            Criado em:
                                            {{
                                                isDate(item.created_at)
                                            }}
                                        </p>
                                        <p
                                            class="text-body-2 text-disabled"
                                        >
                                            Por:
                                            {{ item.created_by.name }}
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
                                        v-for="(
                                            subitem, id
                                        ) in item.subitens"
                                        :key="id"
                                    >
                                        {{ subitem.nome }}
                                    </v-chip>
                                </v-sheet>
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
                                ((itemSelecionado = item),
                                (dialogEditeItem = true))
                            "
                        >
                            <td>{{ item.nome }}</td>
                            <td>
                                <v-chip
                                    v-for="(subitem, idx) in item.subitens.slice(0, 2)"
                                    :key="idx"
                                    size="x-small"
                                    color="green-darken-1"
                                    variant="tonal"
                                    class="font-weight-bold"
                                >
                                    {{ subitem.nome }}
                                </v-chip>
                                <v-btn
                                    v-if="item.subitens.length > 2"
                                    class="text-none text-grey-darken-1 cursor-pointer"
                                    variant="text"

                                    @click.prevent="
                                        ((itemSelecionado = item),
                                        (dialogEditeItem = true))
                                    "
                                >
                                    +{{ item.subitens.length - 2 }} itens
                                </v-btn>
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
        <EditeItem
            v-model="dialogEditeItem"
            :item="itemSelecionado"
            @closeEvent="((itemSelecionado = null), (dialogEditeItem = false))"
            @editProcess="editItem"
        />
        <NovoItem v-model="dialogNovoItem" @insertProcess="insertItem" />
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </DefaultLayout>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import NovoItem from "@/Components/Dialogs/Item/NovoItem.vue";
import EmptyData from "@/Components/EmptyData.vue";
import EditeItem from "@/Components/Dialogs/Item/EditeItem.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { ref } from "vue";

const props = defineProps({
    itens: Object,
    user: Object,
    preferencias: Object,
});

const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Itens", disabled: true },
    { title: "Lista", disabled: true },
];

const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const dados = ref(props.itens ?? []);
const itemSelecionado = ref(null);
const search = ref("");
// Dialogs
const dialogEditeItem = ref(false);
const dialogNovoItem = ref(false);
// Feedback
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});
// functions
async function insertItem(item) {}
function executarBusca() {
    carregandoTodasItens(search.value);
}
async function carregandoTodasItens(termo = "") {
    await axios
        .get(route("item.index"), {
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

<style scoped>
.cursor-pointer:hover{
    text-decoration: underline;
}
</style>
