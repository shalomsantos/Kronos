<template>
    <v-dialog v-model="model" max-width="50vw" height="100vh">
        <v-card rounded="0" class="overflow-y-hidden w-100 h-100">
            <v-toolbar title="Edição do item" density="compact">
                <v-btn
                    icon="mdi-close"
                    size="small"
                    @click="$emit('closeEvent')"
                />
            </v-toolbar>
            <v-card-item class="d-flex ma-0 pa-2">
                <v-row class="ma-0 pa-2">
                    <v-col cols="12">
                        <!-- :model-value="props.itemSelecionado?.nome" -->
                        <v-text-field
                            v-model="inputItemNome"
                            label="Nome do item*"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-select
                            label="Subitens"
                            :items="['Ativo', 'Inativo']"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-select>
                    </v-col>
                    <v-col cols="3">
                        <v-btn
                            class="text-none"
                            color="green-darken-1"
                            size="large"
                            prepend-icon="mdi-plus"
                            @click.prevent="dialogNovoSubitem = true"
                            >Criar novo</v-btn
                        >
                    </v-col>
                    <v-col cols="3">
                        <v-btn
                            class="text-none"
                            color="green-darken-1"
                            size="large"
                            prepend-icon="mdi-playlist-plus"
                            @click="carregandoSubitensPeloItemSelecionado"
                            >Adicionar</v-btn
                        >
                    </v-col>
                    <v-col cols="12">
                        <v-table
                            density="compact"
                            class="bg-green-lighten-5 overflow-y-auto"
                            max-height="340"
                            striped="even"
                        >
                            <thead>
                                <tr>
                                    <th class="text-left">Nome</th>
                                    <th class="text-left">Criado em</th>
                                    <th class="text-left">Criador por</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        item, id
                                    ) in itemSelecionado?.subitens"
                                    :key="id"
                                >
                                    <td>{{ item.nome }}</td>
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
                                </tr>
                            </tbody>
                        </v-table>
                    </v-col>
                </v-row>
            </v-card-item>
        </v-card>
        <!-- Dialogs -->
        <v-dialog v-model="dialogNovoSubitem" max-width="500">
            <v-toolbar title="Novo subitem" density="compact">
                <v-btn
                    icon="mdi-close"
                    size="small"
                    @click.prevent="dialogNovoSubitem = false"
                />
            </v-toolbar>
            <v-card rounded="0" title="Shalom pereira"> </v-card>
        </v-dialog>
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </v-dialog>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { ref, computed, watch } from "vue";
import axios from "axios";

const model = defineModel();
const emit = defineEmits(["editeProcess"]);

const props = defineProps({
    itemSelecionado: {},
});

const itemId = computed(() => props.itemSelecionado?.id ?? null);
const inputItemNome = ref("");
const dialogNovoSubitem = ref(false);

watch(() => props.itemSelecionado,
    (novo) => {
        if (novo) {
            itemId.value = props.itemSelecionado.id;
            inputItemNome.value = props.itemSelecionado.nome;
        }
});

const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

async function carregandoSubitensPeloItemSelecionado() {
    console.log(itemId.value)
    await axios
        .post(route("subitem.subitensAssociaveis"), { itemId: itemId.value })
        .then((res) => {
            console.log(res);
        }).catch((err) => console.log(err));
}

// function editEvent() {
//     if (!inputPlataforma.value) {
//         feedback.value = {
//             show: true,
//             timeout: 4000,
//             color: "warning",
//             text: "O campo nome da plataforma é obrigatório!",
//         };
//         return;
//     }
//     let plataforma = {
//         id: props.plataformaSelecionada.id,
//         nome: inputPlataforma.value,
//         descricao: inputDescricao.value,
//     };
//     inputPlataforma.value = null;
//     inputDescricao.value = null;
//     model.value = false;
//     emit("editeProcess", plataforma);
// }
</script>

<style scoped>
.h-10 {
    height: 9% !important;
}
.h-90 {
    height: 91% !important;
}
</style>
