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
            <v-row class="align-end">
                <v-col cols="6">
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="subitemSelecionado.nome"
                                label="Nome"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="d-flex ga-3">
                            <v-select
                                v-model="valueFornecedor"
                                label="Fornecedor"
                                :items="optionsFornecedor"
                                item-title="optionsFornecedor.razao_social"
                                item-value="optionsFornecedor.id"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                                clearable
                            ></v-select>
                            <v-btn
                                class="text-none rounded"
                                color="green-darken-1"
                                icon="mdi-plus"
                                @click.prevent="updatePlataforma()"
                            />
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="6">
                    <v-btn
                        class="text-none w-100"
                        color="green-darken-1"
                        prepend-icon="mdi-playlist-plus"
                        @click.prevent="updatePlataforma()"
                        >Atualizar</v-btn
                    >
                </v-col>
                <v-col cols="12">
                    <v-table
                        class="bg-green-lighten-5 overflow-y-auto"
                        density="compact"
                        striped="even"
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
            </v-row>
        </Dialog>

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
