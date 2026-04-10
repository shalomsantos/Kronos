<template>
    <DefaultLayout
        v-model="viewOption"
        :title="'Subitens lista'"
        :location="location"
    >
        <v-sheet class="d-flex ga-3 mb-3" color="transparent">
            <v-btn
                @click.prevent="dialogNovoItem = true"
                class="text-none"
                color="green-darken-1"
                prepend-icon="mdi-plus"
                text="Adicionar"
            />
            <v-text-field
                v-model="search"
                placeholder="Pesquisar aqui..."
                variant="outlined"
                density="compact"
                hide-details="auto"
                clearable
            />
        </v-sheet>
        <v-row>
            <v-col
                cols="6"
                v-for="(item, id) in subitens"
                :key="id"
                v-if="subitens.length > 0 && viewOption"
            >
                <v-hover>
                    <template v-slot:default="{ isHovering, props }">
                        <v-card
                            v-bind="props"
                            :title="item.nome"
                            prepend-icon="mdi-apple-keyboard-option"
                            :color="isHovering ? 'green-lighten-5' : undefined"
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
                                        {{ fornecedor.nome_fantasia }}
                                    </v-chip>
                                </v-sheet>
                            </template>
                        </v-card>
                    </template>
                </v-hover>
            </v-col>
            <v-col cols="12" v-else-if="subitens.length > 0 && !viewOption">
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
                            v-for="(item, id) in subitens"
                            :key="id"
                            @click.prevent="
                                ((projetoSelecionado = item),
                                (dialogEditProjeto = true))
                            "
                        >
                            <td>{{ item.nome }}</td>
                            <td>
                                <v-chip
                                    size="x-small"
                                    color="green"
                                    variant="flat"
                                    v-for="(subitem, id) in item.subitens"
                                    :key="id"
                                >
                                    {{ subitem.nome }}
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

        <Dialog
            v-model="dialogEditSubitem"
            title="Editar Subitem"
            width="60vw"
            @onCloseDialog="dialogEditSubitem = false"
        >
            <v-row dense>
                <v-col cols="5">
                    <v-row>
                        <v-col class="d-flex align-center ga-3 mb-0 pb-0">
                            <h4 class="text-green-darken-4">
                                {{ subitemSelecionado.nome }}
                            </h4>
                            <v-btn
                                class="rounded"
                                icon="mdi-pencil"
                                variant="tonal"
                                size="x-small"
                                color="green-darken-4"
                                @click.prevent
                            ></v-btn>

                            <!-- <v-text-field
                                        v-model="inputItemNome"
                                        label="Nome do item*"
                                        variant="outlined"
                                        density="compact"
                                        hide-details="auto"
                                        clearable
                                    ></v-text-field> -->
                        </v-col>
                        <v-col cols="12">
                            <v-combobox
                                v-model="inputSubitem"
                                :items="[
                                    'Demostrativo um',
                                    'Demostrativo Dois',
                                    'Demostrativo três',
                                ]"
                                label="Escolher ou inserir subitem"
                                variant="outlined"
                                density="compact"
                                hide-details
                                item-title="nome"
                                clearable
                            >
                                <template v-slot:prepend-item>
                                    <v-divider></v-divider>
                                    <v-list-item
                                        title="Não encontrou?"
                                        subtitle="Clique para cadastrar um novo"
                                        prepend-icon="mdi-plus-circle-outline"
                                        color="primary"
                                        @click="dialogNovoSubitem = true"
                                    >
                                    </v-list-item>
                                    <v-divider></v-divider>
                                </template>

                                <template v-slot:no-data>
                                    <v-list-item
                                        title="Nenhum item encontrado"
                                        subtitle="Clique aqui para criar um novo"
                                        @click="dialogNovoSubitem = true"
                                    ></v-list-item>
                                </template>
                            </v-combobox>
                        </v-col>
                        <v-col cols="12">
                            <v-btn
                                class="text-none w-100"
                                color="green-darken-1"
                                prepend-icon="mdi-playlist-plus"
                                @click="carregandoSubitensPeloItemSelecionado"
                                text="Adicionar"
                            />
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="7">
                    <v-table
                        density="compact"
                        class="overflow-y-auto"
                        height="200"
                        striped="even"
                        fixed-header
                    >
                        <thead>
                            <tr>
                                <th class="text-left">Razão social</th>
                                <th class="text-left">Criado em</th>
                                <th class="text-left">Por</th>
                                <th class="text-left">***</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(
                                    item, id
                                ) in subitemSelecionado.fornecedores"
                                :key="id"
                            >
                                <td>{{ item.razao_social }}</td>
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
                                        variant="text"
                                        icon="mdi-delete"
                                        density="compact"
                                        color="red"
                                        @click.prevent="confirmation = true"
                                    ></v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-col>
            </v-row>
        </Dialog>

        <v-dialog v-model="confirmation" max-width="500">
            <v-toolbar title="Confirmar operação?" density="compact"></v-toolbar>
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

        <NormalFeedback v-model="feedback"></NormalFeedback>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import Dialog from "@/Components/Dialogs/Dialog.vue";
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { onMounted, ref } from "vue";
import axios from "axios";

const props = defineProps({
    subitens: { type: Object },
    user: { type: Object },
    preferencias: { type: Object },
});
const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Subitem", disabled: true },
    { title: "Lista", disabled: true },
];

onMounted(() => {
    carregandoFornecedores();
});

const dialogEditSubitem = ref(false);
const confirmation = ref(false);
const subitemSelecionado = ref(null);
// dialog forms
const valueFornecedor = ref(null);
const optionsFornecedor = ref([]);
// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

const carregandoFornecedores = async () => {
    await axios
        .get(route("fornecedor.index"))
        .then((res) => {
            optionsFornecedor.value = res.data.data;
        })
        .catch((err) => console.error(err));
};
</script>

<style scoped></style>
