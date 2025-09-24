<template>
    <DefaultLayout
        v-model="viewOption"
        :title="'Bases Lista'"
        :location="location"
        @filter="dialogFilter = !dialogFilter"
        @newBasezero="dialogNewBasezero = !dialogNewBasezero"
    >
        <v-sheet class="bg-transparent">
            <v-row
                class="bg-transparent"
                v-if="dados.length > 0 && viewOption"
            >
                <v-col cols="3" v-for="(item, id) in dados" :key="id">
                    <v-hover>
                        <template v-slot:default="{ isHovering, props }">
                            <v-card
                                v-bind="props"
                                :color="
                                    isHovering ? 'teal-lighten-5' : undefined
                                "
                            >
                                <template v-slot:title>
                                    <v-btn
                                        variant="outlined"
                                        color="green-darken-1"
                                    >
                                        <p class="text-h6 text-green-darken-1">
                                            #{{ item.id }}
                                        </p>
                                        <v-icon
                                            icon="mdi-text-box"
                                            color="green-darken-1"
                                        ></v-icon>
                                    </v-btn>
                                    {{ item.projeto.nome }}
                                </template>
                                <template v-slot:item>
                                    <v-row no-gutters class="pt-2">
                                        <v-col>
                                            <p class="text-body-2">Status</p>
                                            <div>
                                                <p class="text-body-2 text-disabled">{{ item.status.nome }}</p>
                                            </div>
                                        </v-col>
                                        <v-col>
                                            <p class="text-body-2">Ano</p>
                                            <div>
                                                <p class="text-body-2 text-disabled">{{ item.ano }}</p>
                                            </div>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-chip size="x-small" color="green" variant="flat">
                                                {{ item.created_by.name }}
                                            </v-chip>
                                        </v-col>
                                    </v-row>
                                </template>
                            </v-card>
                        </template>
                    </v-hover>
                </v-col>
            </v-row>
            <v-table
                density="compact"
                v-else-if="dados.length > 0 && !viewOption"
                striped="even"
            >
                <thead>
                    <tr>
                        <th class="text-left">Id</th>
                        <th class="text-left">Projeto</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Ano</th>
                        <th class="text-left">***</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, id) in dados" :key="id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.projeto.nome }}</td>
                        <td>{{ item.status.nome }}</td>
                        <td>{{ item.ano }}</td>
                        <td>
                            <v-btn
                                class="text-none me-1"
                                icon="mdi-delete"
                                density="compact"
                                color="red-lighten-2"
                            ></v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
            <EmptyData v-else />
        </v-sheet>
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
        <!-- Dialogs -->
        <v-dialog v-model="dialogFilter" max-width="480">
            <v-card
                title="lorem ipsum"
                subtitle="lorem ipsum lorem ipsum"
                text="lorem ipsumlorem ipsum"
            ></v-card>
        </v-dialog>
        <v-dialog v-model="dialogNewBasezero" max-width="650">
            <v-toolbar title="Nova Base zero" density="compact"
                ><v-btn
                    icon="mdi-close"
                    @click.prevent="
                        (dialogNewBasezero = false), endingProcess()
                    "
                ></v-btn
            ></v-toolbar>
            <v-card rounded="0">
                <v-card-item class="ma-0 pa-2">
                    <v-row dense class="pa-2">
                        <v-col cols="9" class="d-flex ga-2 align-center">
                            <v-select
                                v-model="projetosValue"
                                clearable
                                label="Projetos"
                                :items="projetosOptions"
                                item-title="label"
                                item-value="id"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                            ></v-select>
                            <v-btn
                                class="text-none"
                                :href="route('projeto.index')"
                                prepend-icon="mdi-plus"
                                color="green-darken-1"
                                >Projeto</v-btn
                            >
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
                        <v-col cols="12">
                            <v-textarea
                                v-model="inputDescricao"
                                label="Descrição"
                                variant="outlined"
                                density="compact"
                                clearable
                                hide-details
                                rows="2"
                                auto-grow
                                counter
                            ></v-textarea>
                        </v-col>
                        <v-btn
                            class="text-none"
                            color="green-darken-1"
                            @click.prevent="insertBzero"
                            >Salvar</v-btn
                        >
                    </v-row>
                </v-card-item>
            </v-card>
        </v-dialog>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";

// <===> Context Var <===>
const location = [
    { title: "Base Zero", disabled: false, href: "/" },
    { title: "Lista", disabled: true },
];
const user = usePage().props.auth.user;
const viewOption = ref(user?.preferencia?.listagem_menu ?? 0);
const dados = ref([]);
// <===> Form and Options <===>
const projetosValue = ref(null);
const projetosOptions = ref([]);
const ano = ref(null);
const inputDescricao = ref(null);

// <===> Default Load Page <===>
onMounted(() => {
    carregandoTodosProjetos();
    carregandoTodosBases();
});

// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

// <===> Dialogs <===>
const dialogFilter = ref(false);
const dialogNewBasezero = ref(false);

// <===> Functions <===>
async function carregandoTodosBases() {
    await axios
        .get(route("bzero.index"), {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            dados.value = res.data;
        })
        .catch((err) => console.log(err));
}
async function carregandoTodosProjetos() {
    await axios
        .get(route("projeto.index"), {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            projetosOptions.value = reducingContent(res.data);
        })
        .catch((err) => console.log(err));
}
async function insertBzero() {
    if (projetosValue.value == null || ano.value == null){
        alert(
            "Certifique-se de que os campos projeto e ano estão preenchidos."
        );
        return;
    }

    let data = {
        projeto_id: projetosValue.value,
        ano: ano.value,
        descricao: inputDescricao.value,
    };
    await axios
        .post(route("bzero.store"), data)
        .then((res) => {
            if (res.data.success) {
                carregandoTodosBases();
                endingProcess();
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "success",
                    text: res.data.message,
                };
            } else {
                endingProcess();
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "error",
                    text: res.data.message ?? res.data,
                };
            }
        })
        .catch((err) => {
            endingProcess();
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: err,
            };
        });
}
function reducingContent(data) {
    return data.map((item) => ({
        id: item.id,
        label: item.nome || item.label || "",
    }));
}
function endingProcess() {
    carregandoTodosBases()
    projetosValue.value = null;
    ano.value = null;
    inputDescricao.value = null;

    dialogNewBasezero.value = false;
}
</script>

<style scoped></style>
