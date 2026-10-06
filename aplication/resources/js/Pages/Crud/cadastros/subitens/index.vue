<template>
    <DefaultLayout
        v-model="viewOption"
        title="Subitens"
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
                            @click:clear="carregandoTodasSubitens('')"
                        />
                    </v-col>
                    <v-col align="end">
                        <v-btn
                            class="text-none"
                            color="green-darken-1"
                            prepend-icon="mdi-plus"
                            text="Novo subitem"
                            @click.prevent="dialogNovoSubitem = true"
                        />
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12">
                <EmptyData v-if="!dados?.length" />
                <ViewMode v-else :mode="viewOption">
                    <template #table>
                        <SubitemTable
                            :items="dados"
                            @editar="abrirEdicao"
                            @excluir="confirmation = true"
                        />
                    </template>
                    <template #cards>
                        <SubitemCards
                            :items="dados"
                            @editar="abrirEdicao"
                        />
                    </template>
                </ViewMode>
            </v-col>
        </v-row>

        <EditeSubitem
            v-model="dialogEditSubitem"
            :subitem="subitemSelecionado"
            @onCloseDialog="
                ((subitemSelecionado = null), (dialogEditSubitem = false))
            "
        />
        <NovoSubitem
            v-model="dialogNovoSubitem"
            @insertProcess="insertSubitem"
        />
    </DefaultLayout>
</template>

<script setup>
import ViewMode from "@/Components/Shared/ViewMode.vue";
import SubitemTable from "@/Components/Cadastros/Subitem/SubitemTable.vue";
import SubitemCards from "@/Components/Cadastros/Subitem/SubitemCards.vue";
import EditeSubitem from "@/Components/Dialogs/Subitens/EditeSubitem.vue";
import { useFeedback } from "@/Composables/useFeedback";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import axios from "axios";
import { ref } from "vue";
import NovoSubitem from "@/Components/Dialogs/Subitens/NovoSubitem.vue";
import { useSubitem } from "@/Composables/useSubitem";

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
const { trigger } = useFeedback();
const { store } = useSubitem();

const viewOption = ref(Number(props.preferencias?.listagem_menu ?? 0));
const dados = ref(props.subitens ?? []);
const subitemSelecionado = ref(null);
const search = ref("");
// dialog
const dialogEditSubitem = ref(false);
const dialogNovoSubitem = ref(false);
const confirmation = ref(false);

async function insertSubitem(item) {
    try{
        const res = await store(item);
        if(res.success) {
            trigger(res.message, "success");
            return;
        }
        trigger(res.message || 'Erro sem idenficação.', "error");
    } catch(err) {
        trigger(err, "error");
    } finally{
        carregandoTodasSubitens();
    }
}
const executarBusca = async () => {
    await carregandoTodasSubitens(search.value);
};
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
function abrirEdicao(item) {
    subitemSelecionado.value = item;
    dialogEditSubitem.value = true;
}

</script>

<style scoped></style>
