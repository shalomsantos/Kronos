<template>
    <Dialog
        v-model="model"
        title="Editar Subitem"
        width="60vw"
        @onCloseDialog="$emit('onCloseDialog')"
    >
        <v-row dense>
            <v-col cols="5">
                <v-row>
                    <v-col class="d-flex align-center ga-3 mb-0 pb-0">
                        <h4 class="text-green-darken-4">
                            {{ inputSubitemNome }}
                        </h4>
                        <v-btn
                            class="rounded"
                            icon="mdi-pencil"
                            variant="tonal"
                            size="x-small"
                            color="green-darken-4"
                            @click.prevent
                        ></v-btn>
                    </v-col>
                    <v-col cols="12">
                        <v-combobox
                            v-model="inputFornecedores"
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
                                >
                                </v-list-item>
                                <v-divider></v-divider>
                            </template>

                            <template v-slot:no-data>
                                <v-list-item
                                    title="Nenhum item encontrado"
                                    subtitle="Clique aqui para criar um novo"
                                ></v-list-item>
                            </template>
                        </v-combobox>
                    </v-col>
                    <v-col cols="12">
                        <v-btn
                            class="text-none w-100"
                            color="green-darken-1"
                            prepend-icon="mdi-playlist-plus"
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
                            ) in subitem?.fornecedores"
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
</template>

<script setup>
import Dialog from "../Dialog.vue";
import { ref, watch } from "vue";

const model = defineModel();

const props = defineProps({
    subitem: Object,
});

const subitemId = ref(null);
const inputSubitemNome = ref("");
const inputFornecedores = ref(null);

watch(
    () => props.subitem,
    (novo) => {
        if (novo) {
            subitemId.value = props.subitem?.id;
            inputSubitemNome.value = props.subitem?.nome;
        }
    }, { immediate: true }
);
</script>

<style scoped></style>
