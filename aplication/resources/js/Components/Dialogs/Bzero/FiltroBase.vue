<template>
    <v-dialog v-model="model" max-width="500">
        <v-toolbar title="Filtro" density="compact"
            ><v-btn
                icon="mdi-close"
                size="small"
                @click.prevent="
                    (model = false),
                    (id = null),
                    (projeto_id = null),
                    (status_id = null),
                    (ano = null),
                    (created_at_start = null),
                    (created_at_end = null)
                "
            ></v-btn
        ></v-toolbar>
        <v-card rounded="0">
            <v-card-item class="ma-0 pa-2">
                <v-row class="pa-2">
                    <v-col cols="3">
                        <v-text-field
                            v-model="id"
                            label="Id"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="9">
                        <v-select
                            v-model="projeto_id"
                            label="Projetos"
                            :items="itensProjetos"
                            item-title="label"
                            item-value="id"
                            clearable
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                        ></v-select>
                    </v-col>
                    <v-col cols="3">
                        <v-text-field
                            v-model="ano"
                            label="Ano"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="9">
                        <v-select
                            v-model="status_id"
                            label="Status"
                            :items="itensStatus"
                            item-title="label"
                            item-value="id"
                            clearable
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                        ></v-select>
                    </v-col>
                    <v-col cols="12"
                        ><p class="text-disabled">Criado Entre:</p></v-col
                    >
                    <v-col cols="4">
                        <v-text-field
                            v-model="created_at_start"
                            type="date"
                            label="Início"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4">
                        <v-text-field
                            v-model="created_at_end"
                            type="date"
                            label="Fim"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" class="d-flex justify-space-between ga-2 pt-3">
                        <v-btn
                            class="text-none"
                            size="large"
                            color="green-darken-3"
                            prepend-icon="mdi-filter-outline"
                            @click.prevent="carregar()"
                            >Carregar</v-btn
                        >
                        <v-btn
                            class="text-none"
                            size="large"
                            color="blue-darken-3"
                            prepend-icon="mdi-backspace-outline"
                            @click.prevent="
                                (id = null),
                                (projeto_id = null),
                                (status_id = null),
                                (ano = null),
                                (created_at_start = null),
                                (created_at_end = null)
                            "
                        >Limpar</v-btn>
                    </v-col>
                </v-row>
            </v-card-item>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const model = defineModel();
const emit = defineEmits(["onFilter"]);

// Inputs
const id = ref(null);
const projeto_id = ref(null);
const itensProjetos = ref([]);
const status_id = ref(null);
const itensStatus = ref([]);
const ano = ref(null);
const created_at_start = ref(null);
const created_at_end = ref(null);

onMounted(() => {
    carregandoTodosProjetos();
    carregandoTodosStatus();
});

function carregar() {
    const data = {
        id: id.value,
        projeto_id: projeto_id.value,
        ano: ano.value,
        status_id: status_id.value,
        created_at_start: created_at_start.value,
        created_at_end: created_at_end.value,
    };
    emit("onFilter", data);
}

async function carregandoTodosProjetos() {
    await axios
        .get(route("projeto.index"), {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            itensProjetos.value = reducingContent(res.data) ?? [];
        })
        .catch((err) => console.log(err));
}

async function carregandoTodosStatus() {
    await axios
        .get(route("status.index"), {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            itensStatus.value = reducingContent(res.data) ?? [];
        })
        .catch((err) => console.log(err));
}

function reducingContent(data) {
    return data.map((item) => ({
        id: item.id,
        label: item.nome || item.label || "",
    }));
}
</script>

<style scoped></style>
