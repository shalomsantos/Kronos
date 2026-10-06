<template>
    <DefaultLayout
        v-model="viewOption"
        title="Edição da base"
        :location="location"
    >
        <v-row dense>
            <v-col cols="12">
                <v-card :title="dados.projeto.nome" class="border-s-lg">
                    <template #item>
                        <p class="text-body-2 text-disabled">
                            {{ dados.descricao }}
                        </p>
                    </template>
                    <template #text>
                        <v-sheet class="d-flex ga-6">
                            <v-sheet>
                                <p class="text-body-2">Status</p>
                                <div>
                                    <p class="text-body-2 text-disabled">
                                        {{ dados.status.nome }}
                                    </p>
                                </div>
                            </v-sheet>
                            <v-sheet>
                                <p class="text-body-2">Ano</p>
                                <div>
                                    <p class="text-body-2 text-disabled">
                                        {{ dados.ano }}
                                    </p>
                                </div>
                            </v-sheet>
                            <v-sheet>
                                <p class="text-body-2">Criado em</p>
                                <div>
                                    <p class="text-body-2 text-disabled">
                                        {{ isDate(dados.created_at) }}
                                    </p>
                                </div>
                            </v-sheet>
                            <v-sheet>
                                <p class="text-body-2">Por</p>
                                <div>
                                    <p class="text-body-2 text-disabled">
                                        {{ dados.created_by.name }}
                                    </p>
                                </div>
                            </v-sheet>
                        </v-sheet>
                    </template>
                </v-card>
                <v-row class="py-3">
                    <v-col cols="4">
                        <v-select
                            v-model="valuePlataforma"
                            clearable
                            variant="outlined"
                            label="Selecione uma plataforma"
                            color="green-darken-3"
                            :items="plataformas"
                            density="compact"
                            item-title="nome"
                            item-value="id"
                            hide-details="auto"
                        >
                            <template #append>
                                <v-btn
                                    variant="flat"
                                    color="green-darken-3"
                                    icon="mdi-plus"
                                    class="rounded"
                                    density="comfortable"
                                    :disabled="
                                        valuePlataforma == null ? true : false
                                    "
                                    @click.prevent="associarPlataforma"
                                />
                            </template>
                        </v-select>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12">
                <EmptyData v-if="!dados?.plataformas?.length" />
                <ViewMode v-else :mode="viewOption">
                    <template #table>
                        <BzeroTable
                            :plataformas="dados.plataformas"
                            @editar="openEditeItem"
                            @adicionar="abrirInclusao"
                            @anexar="anexarItem"
                        />
                    </template>
                    <template #cards>
                        <BzeroCards
                            :plataformas="dados.plataformas"
                            @editar="openEditeItem"
                            @adicionar="abrirInclusao"
                            @anexar="anexarItem"
                        />
                    </template>
                </ViewMode>
            </v-col>
        </v-row>
        <IncluirItem
            v-model="dialogAdicionarItem"
            :bzero-id="dados.id"
            :plataforma="plataformaSelecionada"
            @incluirProcess="((dialogAdicionarItem=false))"
            @onCloseDialog="dialogAdicionarItem=false"
        />
        <EditarItem
            v-model="dialogEditarItem"
            :itemEdited="itemEdited"
            @incluirProcess="((dialogEditarItem=false))"
            @onCloseDialog="dialogEditarItem=false"
        />
    </DefaultLayout>
</template>

<script setup>
import IncluirItem from "@/Components/Dialogs/Bzero/IncluirItem.vue";
import EditarItem from "@/Components/Dialogs/Bzero/EditarItem.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { useFeedback } from "@/Composables/useFeedback";
import ViewMode from "@/Components/Shared/ViewMode.vue";
import BzeroTable from "@/Components/Bzero/BzeroTable.vue";
import BzeroCards from "@/Components/Bzero/BzeroCards.vue";
import EmptyData from "@/Components/EmptyData.vue";
import { ref, computed } from "vue";
import axios from "axios";

const props = defineProps({
    bzero: Object,
    preferencias: Object,
    plataformas: Object,
});

const { trigger } = useFeedback();

const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Base", disabled: true },
    { title: "Edição", disabled: true },
];

const viewOption          = ref(Number(props.preferencias?.listagem_menu ?? 0));
const dados               = ref(props.bzero);
const valuePlataforma     = ref(null);
const plataformas         = computed(() => props.plataformas);
const itemEdited          = ref(null)
const dialogAdicionarItem = ref(null);
const dialogEditarItem    = ref(null);

const plataformaSelecionada = ref(null);

function abrirInclusao(plataforma) {
    plataformaSelecionada.value = plataforma;
    dialogAdicionarItem.value = true;
}

function anexarItem(item) {
    console.log("Anexar no ID:", item);
}

function openEditeItem(item) {
    itemEdited.value = item;
    dialogEditarItem.value = true;
}

async function associarPlataforma() {
    await axios
        .post(route("associar.plataforma", { id: dados.value.id }), {
            plataforma_id: valuePlataforma.value,
        })
        .then((res) => {
            if (res.data.success) {
                dados.value = res.data.data;
                valuePlataforma.value = null;
                trigger(res.data.message, 'success')
                return;
            }
            trigger(res.data.message, 'error')
        })
        .catch((err) => {
            trigger(err.data.message, 'error')
        });
}
</script>
