<template>
    <DefaultLayout
        v-model="viewOption"
        title="Bases Lista"
        :location="location"
    >
        <v-row dense>
            <v-col cols="12">
                <v-card :title="dados.projeto.nome" class="border-s-lg">
                    <template #item>
                        <p class="text-body-2 text-disabled">
                            {{ dados.descricao }}
                        </p>
                    </template>
                    <template #text>
                        <v-row>
                            <v-col cols="4" lg="2">
                                <p class="text-body-2">Status</p>
                                <div>
                                    <p class="text-body-2 text-disabled">
                                        {{ dados.status.nome }}
                                    </p>
                                </div>
                            </v-col>
                            <v-col cols="4" lg="2">
                                <p class="text-body-2">Ano</p>
                                <div>
                                    <p class="text-body-2 text-disabled">
                                        {{ dados.ano }}
                                    </p>
                                </div>
                            </v-col>
                            <v-col cols="4" lg="2">
                                <p class="text-body-2">Criado em</p>
                                <div>
                                    <p class="text-body-2 text-disabled">
                                        {{ isDate(dados.created_at) }}
                                    </p>
                                </div>
                            </v-col>
                            <v-col cols="4" lg="2">
                                <p class="text-body-2">Por</p>
                                <div>
                                    <p class="text-body-2 text-disabled">
                                        {{ dados.created_by.name }}
                                    </p>
                                </div>
                            </v-col>
                        </v-row>
                    </template>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                v-if="dados && !viewOption"
            >
                <v-table density="compact" striped="even">
                        <thead>
                            <tr>
                                <th class="text-left normal">Item</th>
                                <th class="text-left normal">Subitem</th>
                                <th class="text-left normal">Fornecedor</th>
                                <th class="text-left small">Valor Unit.</th>
                                <th class="text-left small">Quant.</th>
                                <th class="text-left small">Unid.</th>
                                <th class="text-left small">Valor Total</th>
                            </tr>
                        </thead>
                </v-table>
            </v-col>
            <v-col
                cols="6"
                v-if="dados && viewOption"
                v-for="(item, id) in dados.plataformas"
                :key="id"
            >
                <v-card v-bind="props">
                    <template #title>
                        {{ item.nome }}
                    </template>
                    <template #item>
                        <v-sheet class="d-flex flex-wrap ga-2 pa-1">
                            <v-card
                                v-for="itemPivot in item.itens_pivot"
                                :key="id"
                                elevation="5"
                            >
                                <template #title>
                                    {{ itemPivot.subitem.nome }}
                                </template>
                                <template #subtitle>
                                    {{ itemPivot.item.nome }}
                                </template>
                                <template #text>
                                    {{ itemPivot.fornecedor?.razao_social }}
                                </template>
                            </v-card>
                        </v-sheet>
                    </template>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                v-else-if="dados && !viewOption"
                v-for="plataforma in dados.plataformas"
                :key="plataforma.id"
            >
                <h4>{{ plataforma.nome }}</h4>
                <v-table density="compact" striped="even">
                    <tbody>
                        <tr
                            v-for="itemPivot in plataforma.itens_pivot"
                            :key="id"
                        >
                            <td class="normal">{{ itemPivot.item.nome }}</td>
                            <td class="normal">{{ itemPivot.subitem.nome }}</td>
                            <td class="normal">{{ itemPivot.fornecedor?.razao_social }}</td>
                            <td class="small">
                                R$ {{ itemPivot.vl_unit_cot.replace(".", ",") }}
                            </td>
                            <td class="small">{{ itemPivot.qt_unidade_cot }}</td>
                            <td class="small">{{ itemPivot.qt_multip_uni_cot }}</td>
                            <td class="small">
                                R$
                                {{
                                    (
                                        itemPivot.vl_unit_cot *
                                        itemPivot.qt_unidade_cot *
                                        itemPivot.qt_multip_uni_cot
                                    ).toLocaleString("pt-BR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                    })
                                }}
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-col>
            <v-col cols="12" v-else>
                <EmptyData />
            </v-col>
        </v-row>
        <NormalFeedback v-model="feedback" />
    </DefaultLayout>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import { ref } from "vue";

const props = defineProps({
    bzero: Object,
    preferencias: Object,
});

const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Base", disabled: true },
    { title: "Edição", disabled: true },
];

const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const dados = ref(props.bzero);

// Feedback
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});
</script>

<style scoped>
.border-s-lg {
    border-color: #81c784 !important;
}
th.normal, td.normal{
    width: 10vw;
    margin: 0;
    padding: 0;
}
th.small, td.small{
    width: 3vw;
    margin: 0;
    padding: 0;
    background-color: rgba(128, 128, 128, 0.474);
}
</style>
