<template>
    <DefaultLayout
        v-model="viewOption"
        title="Itens"
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
                            @click:clear="limparBusca"
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
            <v-col cols="12">
                <EmptyData v-if="!dados?.length" />
                <ViewMode v-else :mode="viewOption">
                    <template #table>
                        <ItemTable
                            :items="dados"
                            @editar="abrirEdicao"
                        />
                    </template>
                    <template #cards>
                        <ItemCards
                            :items="dados"
                            @editar="abrirEdicao"
                        />
                    </template>
                </ViewMode>
            </v-col>
        </v-row>

        <EditeItem
            v-model="dialogEditeItem"
            :item="itemSelecionado"
            :subitens="props.subitens"
            @closeEvent="((itemSelecionado = null), (dialogEditeItem = false))"
            @editProcess="editItem"
        />
        <NovoItem v-model="dialogNovoItem" @insertProcess="insertItem" />
    </DefaultLayout>
</template>

<script setup>
import ViewMode from "@/Components/Shared/ViewMode.vue";
import ItemTable from "@/Components/Cadastros/Item/ItemTable.vue";
import ItemCards from "@/Components/Cadastros/Item/ItemCards.vue";
import NovoItem from "@/Components/Dialogs/Item/NovoItem.vue";
import EditeItem from "@/Components/Dialogs/Item/EditeItem.vue";
import { useFeedback } from "@/Composables/useFeedback";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import { ref, watch } from "vue";
import { useItem } from "@/Composables/useItem";

const props = defineProps({
    itens: Object,
    subitens: Object,
    user: Object,
    preferencias: Object,
});

const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Itens", disabled: true },
    { title: "Lista", disabled: true },
];

const { trigger } = useFeedback();
const { dados, carregarDados, finding } = useItem();

watch(() => props.itens, (novosItens) => { if (novosItens) dados.value = novosItens }, { immediate: true });

const viewOption = ref(Number(props.preferencias?.listagem_menu ?? 0));
const itemSelecionado = ref(null);
const search = ref("");

// Dialogs
const dialogEditeItem = ref(false);
const dialogNovoItem = ref(false);

// functions
async function insertItem() {
    const res = await carregarDados()
    dialogNovoItem.value = false;
    dados.value = res;
}

function editItem(item) {
    console.log(item)
}

const executarBusca = async () => { await finding(search.value) }

async function limparBusca() { await finding('') }
function abrirEdicao(item) {
    itemSelecionado.value = item;
    dialogEditeItem.value = true;
}

</script>

<style scoped>
.cursor-pointer:hover {
    text-decoration: underline;
}
</style>
