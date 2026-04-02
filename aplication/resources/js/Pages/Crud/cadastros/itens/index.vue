<template>
    <DefaultLayout
        v-model="viewOption"
        :title="'Projetos lista'"
        :location="location"
        class="position-relative"
    >
        <v-btn
            @click.prevent="dialogNovoItem = true"
            class="text-none position-absolute rotate ma-3"
            color="green-darken-1"
            size="x-large"
            icon="mdi-plus"
        />
        <v-sheet class="bg-transparent">
            <v-row
                dense
                class="bg-transparent"
                v-if="dados.length > 0 && !viewOption"
            >
                <v-col cols="12" v-for="(item, id) in dados" :key="id">
                    <v-hover>
                        <template v-slot:default="{ isHovering, props }">
                            <v-card
                                v-bind="props"
                                :color="
                                    isHovering ? 'green-lighten-5' : undefined
                                "
                                @click.prevent="(itemSelecionado=item, dialogEditeItem=true)"
                            >
                                <template #title>
                                    <v-row no-gutters>
                                        <v-col cols="10">
                                            {{ item.nome }}
                                        </v-col>
                                        <v-col cols="2" class="text-right">
                                            <p
                                                class="text-body-2 text-disabled"
                                            >
                                                Criado em:
                                                {{ isDate(item.created_at) }}
                                            </p>
                                            <p
                                                class="text-body-2 text-disabled"
                                            >
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
            </v-row>
            <v-table
                class="bg-green-lighten-5"
                density="compact"
                v-else-if="dados.length > 0 && viewOption"
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
                            (projetoSelecionado = item),
                                (dialogEditProjeto = true)
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
                            <v-chip size="x-small" color="green" variant="flat">
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
            <EmptyData v-else />
        </v-sheet>

        <!-- Dialogs -->
        <EditeItem
            v-model="dialogEditeItem"
            :itemSelecionado="itemSelecionado"
            @editProcess="editItem"
            @closeEvent="(itemSelecionado=null, dialogEditeItem=false)"
        ></EditeItem>
        <NovoItem
            v-model="dialogNovoItem"
            @insertProcess="insertItem"
        ></NovoItem>

        <!-- Feedback -->
        <NormalFeedback v-model="feedback"></NormalFeedback>
    </DefaultLayout>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import NovoItem from "@/Components/Dialogs/Item/NovoItem.vue";
import EditeItem from "@/Components/Dialogs/Item/EditeItem.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import { ref } from "vue";

const props = defineProps({
    itens: {},
    user: {},
    preferencias: {},
});

const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Itens", disabled: true },
    { title: "Lista", disabled: true },
];

const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const dados = ref(props.itens ?? []);
const itemSelecionado = ref(null);

// Dialogs
const dialogEditeItem = ref(false);
const dialogNovoItem = ref(false);

// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

async function insertItem() {}
</script>

<style scoped>
.position-absolute {
    bottom: 0;
    right: 0;
}
</style>
