<template>
    <DefaultLayout
        v-model="viewOption"
        :location="location"
        title="Plataformas"
        class="position-relative"
    >
        <v-btn
            @click.prevent="dialogNovaPlataforma = true"
            class="text-none position-absolute rotate ma-3"
            color="green-darken-1"
            size="x-large"
            icon="mdi-plus"
        />
        <v-sheet class="bg-transparent">
            <v-row class="bg-transparent" v-if="dados.length > 0 && viewOption">
                <v-col cols="3" v-for="(item, id) in dados" :key="id">
                    <v-hover>
                        <template v-slot:default="{ isHovering, props }">
                            <v-card
                                :title="item.nome"
                                @click.prevent="editePlataforma(item)"
                                v-bind="props"
                                :color="
                                    isHovering ? 'green-lighten-5' : undefined
                                "
                            >
                                <template v-slot:prepend>
                                    <v-icon
                                        icon="mdi-clipboard-file"
                                        color="green-darken-1"
                                    ></v-icon>
                                </template>
                            </v-card>
                        </template>
                    </v-hover>
                </v-col>
            </v-row>
            <v-table
                class="bg-green-lighten-5"
                density="compact"
                v-else-if="dados.length > 0 && !viewOption"
                striped="even"
            >
                <thead>
                    <tr>
                        <th class="text-left">Nome</th>
                        <th class="text-left">Criado em</th>
                        <th class="text-left">Criado por</th>
                        <th class="text-left">***</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, id) in dados"
                        :key="id"
                        @click.prevent="editePlataforma(item)"
                    >
                        <td>{{ item.nome }}</td>
                        <td>{{ isDate(item.created_at) }}</td>
                        <td>
                            <v-chip size="x-small" color="green" variant="flat">
                                {{ item.created_by?.name }}
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
        <EditePlataforma
            v-model="dialogEditePlataforma"
            :plataformaSelecionada="plataformaSelecionada"
        />
        <NovaPlataforma
            v-model="dialogNovaPlataforma"
            @insertProcess="insertPlataforma"
        />
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </DefaultLayout>
</template>

<script setup>
import EditePlataforma from "@/Components/Dialogs/Plataforma/EditePlataforma.vue";
import NovaPlataforma from "@/Components/Dialogs/Plataforma/NovaPlataforma.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import { ref } from "vue";
import axios from "axios";
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";

const props = defineProps({
    plataformas: {
        type: Array
    },
    user: {
        type: Object
    },
    preferencias: {
        type: Object
    },
});
// content var
const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Plataformas", disabled: true },
    { title: "Lista", disabled: true },
];
const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
// data objects
const dados = ref(props.plataformas);
const plataformaSelecionada = ref(null);
// dialogs
const dialogEditePlataforma = ref(false);
const dialogNovaPlataforma = ref(false);
// Feedback
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});
// functions
async function carregandoTodasPlataformas() {
    await axios
        .get(route("plataforma.index"), {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            dados.value = res.data;
        })
        .catch((err) => console.log(err));
}
async function insertPlataforma(plataforma) {
    await axios
        .post(route("plataforma.store"), plataforma)
        .then((res) => {
            if (res.data.success) {
                carregandoTodasPlataformas();
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "success",
                    text: res.data.message,
                };
                return;
            }
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: res.data.message,
            };
        }).catch((err) => {
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: err,
            };
        });
}
function editePlataforma(plataforma) {
    plataformaSelecionada.value = plataforma;
    dialogEditePlataforma.value = true;
}
</script>

<style scoped>
.position-absolute {
    bottom: 0;
    right: 0;
}
</style>
