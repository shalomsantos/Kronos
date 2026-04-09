<template>
    <v-dialog v-model="model" max-width="80vw">
        <v-card rounded="0" class="overflow-y-hidden w-100 h-100">
            <v-toolbar
                title="Editar ou vincular subitens a este item?"
                density="compact"
            >
                <v-btn
                    icon="mdi-close"
                    size="small"
                    @click="$emit('closeEvent')"
                />
            </v-toolbar>
            <v-card-item class="ma-0 pa-0">
                <v-sheet class="pa-4">
                    <v-row dense>
                        <v-col cols="4">
                            <v-row>
                                <v-col
                                    class="d-flex align-center ga-3 mb-0 pb-0"
                                >
                                    <h4 class="text-green-darken-4">
                                        {{ inputItemNome }}
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
                                                title="Deseja inserir um novo subitem?"
                                                subtitle="Clique para cadastrar um novo"
                                                prepend-icon="mdi-plus-circle-outline"
                                                color="primary"
                                                @click="
                                                    dialogNovoSubitem = true
                                                "
                                            >
                                            </v-list-item>
                                            <v-divider></v-divider>
                                        </template>

                                        <template v-slot:no-data>
                                            <v-list-item
                                                title="Nenhum item encontrado"
                                                subtitle="Clique aqui para criar um novo"
                                                @click="
                                                    dialogNovoSubitem = true
                                                "
                                            ></v-list-item>
                                        </template>
                                    </v-combobox>
                                </v-col>
                                <v-col cols="12">
                                    <v-btn
                                        class="text-none w-100"
                                        color="green-darken-1"
                                        prepend-icon="mdi-playlist-plus"
                                        @click="
                                            carregandoSubitensPeloItemSelecionado
                                        "
                                        text="Adicionar"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="8">
                            <v-table
                                density="compact"
                                class="overflow-y-auto"
                                height="200"
                                striped="even"
                            >
                                <thead>
                                    <tr>
                                        <th class="text-left">Nome</th>
                                        <th class="text-left">Criado em</th>
                                        <th class="text-left">Criador por</th>
                                        <th class="text-left">***</th>
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
                                        <td>
                                            <v-btn
                                                icon="mdi-delete"
                                                variant="text"
                                                density="compact"
                                                color="red"
                                                @click.prevent="deleteItem()"
                                            ></v-btn>
                                        </td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </v-col>
                    </v-row>
                </v-sheet>
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
        <v-dialog v-model="confirmation" max-width="500">
            <v-toolbar title="Confirmar operação?" density="compact"> </v-toolbar>
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
const confirmation = ref(false);
const inputSubitem = ref([]);

watch(
    () => props.itemSelecionado,
    (novo) => {
        if (novo) {
            itemId.value = props.itemSelecionado.id;
            inputItemNome.value = props.itemSelecionado.nome;
        }
    },
);

const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

async function carregandoSubitensPeloItemSelecionado() {
    console.log(itemId.value);
    await axios
        .post(route("subitem.subitensAssociaveis"), { itemId: itemId.value })
        .then((res) => {
            console.log(res);
        })
        .catch((err) => console.log(err));
}
function deleteItem() {
    confirmation.value = true;
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
