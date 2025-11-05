<template>
    <v-dialog v-model="model" max-width="80vw" height="80vh">
        <v-card rounded="0" class="overflow-y-hidden w-100 h-100">
            <v-toolbar title="Edição da plataforma" density="compact">
                <v-btn
                    icon="mdi-close"
                    size="small"
                    @click.prevent="model = false"
                />
            </v-toolbar>
            <v-card-item class="d-flex ma-0 pa-2">
                <v-row class="pa-2">
                    <v-col cols="3">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="inputPlataforma"
                                    label="Nome da plataforma*"
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
                                    rows="2"
                                    clearable
                                    hide-details
                                    auto-grow
                                    counter
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="9">
                        <v-row>
                            <v-col cols="12" class="ma-0 pa-0 text-center"><p class="text-disabled">Associe o item novo à plataforma</p><hr style="color: #FAFAFA;"></v-col>
                            <v-col cols="4">
                                <v-select
                                    label="Item"
                                    :items="['Ativo', 'Inativo']"
                                    variant="outlined"
                                    density="compact"
                                    hide-details="auto"
                                    clearable
                                ></v-select>
                            </v-col>
                            <v-col cols="4">
                                <v-select
                                    label="Subitem"
                                    :items="['Ativo', 'Inativo']"
                                    variant="outlined"
                                    density="compact"
                                    hide-details="auto"
                                    clearable
                                ></v-select>
                            </v-col>
                            <v-col cols="4">
                                <v-select
                                    label="Fornecedor"
                                    :items="['Ativo', 'Inativo']"
                                    variant="outlined"
                                    density="compact"
                                    hide-details="auto"
                                    clearable
                                ></v-select>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    label="Valor Unitário"
                                    variant="outlined"
                                    density="compact"
                                    hide-details="auto"
                                    clearable
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    v-model="valor"
                                    label="Quantidade"
                                    variant="outlined"
                                    density="compact"
                                    hide-details="auto"
                                    clearable
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    v-model="valor"
                                    label="Unidade"
                                    variant="outlined"
                                    density="compact"
                                    hide-details="auto"
                                    clearable
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <v-btn
                                    class="text-none w-100"
                                    color="green-darken-1"
                                    size="large"
                                    prepend-icon="mdi-update"
                                    @click.prevent="editEvent()"
                                    >Atualizar</v-btn
                                >
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row no-guttters>
                    <v-col cols="12" class="ma-0 pa-0">
                        <v-table
                            class="bg-green-lighten-5 overflow-y-scroll" style="height: 17rem;"
                            density="compact"
                            striped="even"
                        >
                            <thead>
                                <tr>
                                    <th class="text-left">Item</th>
                                    <th class="text-left">Subitem</th>
                                    <th class="text-left">Fornecedor</th>
                                    <th class="text-left">Valor Unit.</th>
                                    <th class="text-left">Quant.</th>
                                    <th class="text-left">Unid.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in desserts" :key="item.name">
                                    <td>{{ item.item }}</td>
                                    <td>{{ item.subitem }}</td>
                                    <td>{{ item.fornecedor }}</td>
                                    <td>{{ item.valor_unit }}</td>
                                    <td>{{ item.quant }}</td>
                                    <td>{{ item.unid }}</td>
                                </tr>
                            </tbody>
                        </v-table>
                    </v-col>
                </v-row>
            </v-card-item>
        </v-card>
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </v-dialog>
</template>

<script setup>
const model = defineModel();
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { ref } from "vue";

const props = defineProps({
    plataformaSelecionada: {
        type: Object,
    },
});

const desserts = [
    {
        item: "Pessoal",
        subitem: "Capatazia",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Pessoal",
        subitem: "Equipe tercerizada",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Pessoal",
        subitem: "Equipe tercerizada",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Pessoal",
        subitem: "Equipe tercerizada",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Pessoal",
        subitem: "Promotor",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Pessoal",
        subitem: "Supervisor de promotor",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
    {
        item: "Serviço",
        subitem: "Manutenção em painel",
        fornecedor: "",
        valor_unit: 0,
        quant: 1,
        unid: 1,
    },
];

const inputPlataforma = ref(props.plataformaSelecionada?.nome ?? null);
const inputDescricao = ref(props.plataformaSelecionada?.descricao ?? null);
const valor = ref(1);
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

const emit = defineEmits(["editeProcess"]);

function editEvent() {
    if (!inputPlataforma.value) {
        feedback.value = {
            show: true,
            timeout: 4000,
            color: "warning",
            text: "O campo nome da plataforma é obrigatório!",
        };
        return;
    }
    let plataforma = {
        id: props.plataformaSelecionada.id,
        nome: inputPlataforma.value,
        descricao: inputDescricao.value,
    };
    inputPlataforma.value = null;
    inputDescricao.value = null;
    model.value = false;
    emit("editeProcess", plataforma);
}
</script>

<style lang="scss" scoped></style>
