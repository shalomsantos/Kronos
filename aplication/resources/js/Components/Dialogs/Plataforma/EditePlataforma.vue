<template>
    <Dialog
        v-model="model"
        title="Editar Plataforma"
        width="80vw"
        @onCloseDialog="$emit('onCloseDialog')"
    >
        <v-row>
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
            <v-col cols="9" class="pa-5">
                <v-row class="border rounded">
                    <v-col cols="12" class="text-center ma-0 pa-0">
                        <p class="text-disabled">
                            Vincular item à plataforma.
                        </p>
                    </v-col>
                    <v-col cols="4">
                        <v-select
                            v-model="valueItens"
                            label="Item"
                            :items="itens"
                            item-title="nome"
                            item-value="id"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-select>
                    </v-col>
                    <v-col cols="4">
                        <v-select
                            v-model="valueSubItens"
                            label="Subitem"
                            :items="subItens"
                            item-title="subitem.nome"
                            item-value="subitem_id"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-select>
                    </v-col>
                    <v-col cols="4">
                        <v-select
                            v-model="valueFornecedores"
                            label="Fornecedor"
                            :items="fornecedores"
                            item-title="fornecedor.razao_social"
                            item-value="fornecedor_id"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-select>
                    </v-col>
                    <v-col cols="4">
                        <v-text-field
                            v-model="valorUnitario"
                            label="Valor Unitário"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            @keypress="onlyNumbers"
                            prefix="R$"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="2">
                        <v-text-field
                            type="number"
                            v-model.number="qt_unidade_cot"
                            label="Quantidade"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="2">
                        <v-text-field
                            type="number"
                            v-model.number="qt_multip_uni_cot"
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
                            @click.prevent="updatePlataforma()"
                            >Atualizar</v-btn
                        >
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-sheet v-if="loading" color="green-lighten-5">
                    <v-skeleton-loader
                        class="mx-auto border"
                        type="table-row-divider@6"
                    ></v-skeleton-loader>
                </v-sheet>

                <v-table
                    v-else-if="PlataformaItemSubitemFornecedor.length > 0"
                    class="bg-green-lighten-5 overflow-y-scroll"
                    style="height: 17rem"
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
                            <th class="text-left">Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(
                                item, id
                            ) in PlataformaItemSubitemFornecedor"
                            :key="id"
                        >
                            <td>{{ item.item.nome }}</td>
                            <td>{{ item.subitem.nome }}</td>
                            <td>{{ item.fornecedor?.razao_social }}</td>
                            <td>R$ {{ item.vl_unit_cot.replace(".", ",") }}</td>
                            <td>{{ item.qt_unidade_cot }}</td>
                            <td>{{ item.qt_multip_uni_cot }}</td>
                            <td>
                                R$
                                {{
                                    (
                                        item.vl_unit_cot *
                                        item.qt_unidade_cot *
                                        item.qt_multip_uni_cot
                                    ).toLocaleString("pt-BR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                    })
                                }}
                            </td>
                        </tr>
                    </tbody>
                </v-table>

                <v-sheet
                    v-else
                    color="green-lighten-5"
                    class="text-center pt-8 pb-16 rounded border border-success"
                >
                    <h3 class="text-grey-darken-1">
                        Nenhum resultado encontrado.
                    </h3>
                </v-sheet>
            </v-col>
        </v-row>
        <NormalFeedback v-model="feedback" />
    </Dialog>
</template>

<script setup>
const model = defineModel();
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { ref, watch, computed } from "vue";
import Dialog from "../Dialog.vue";

const props = defineProps({
    plataforma: Object,
});
const emit = defineEmits(['onCloseDialog']);
const inputIdPlataforma = ref("");
const inputPlataforma = ref("");
const inputDescricao = ref("");

const valueItens = ref(null);
const itens = ref([]);

const valueSubItens = ref(null);
const subItens = ref([]);

const valueFornecedores = ref(null);
const fornecedores = ref([]);

const vl_unit_cot = ref(0);
const qt_unidade_cot = ref(1);
const qt_multip_uni_cot = ref(1);
// dados
const PlataformaItemSubitemFornecedor = ref([]);
// feedbacks
const loading = ref(false);
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

watch(
    () => props.plataforma,
    (novo) => {
        if (novo) {
            inputIdPlataforma.value = novo.id ?? "";
            inputPlataforma.value = novo.nome ?? "";
            inputDescricao.value = novo.descricao ?? "";
            carregandoPlataformaItemSubitemFornecedor(novo.id);
            carregandoTodosItens();
        }
    },
    { immediate: true },
);
watch(
    () => valueItens.value,
    (novo) => {
        if (novo) {
            carregaItensSubitens(novo);
        } else if (novo == null) {
            subItens.value = [];
            valueSubItens.value = null;
        }
    },
    { immediate: true },
);
watch(
    () => valueSubItens.value,
    (novo) => {
        if (novo) {
            carregaSubitensFornecedores(novo);
        } else if (novo == null) {
            fornecedores.value = [];
            valueFornecedores.value = null;
        }
    },
    { immediate: true },
);

const valorUnitario = computed({
    get() {
        return vl_unit_cot.value.toLocaleString("pt-BR", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
    },
    set(newValue) {
        if (!newValue) {
            vl_unit_cot.value = 0;
            return;
        }
        let value = String(newValue).replace(/\D/g, "");
        vl_unit_cot.value = parseFloat(value) / 100;
    },
});
const onlyNumbers = (event) => {
    if (!/[0-9]/.test(event.key)) {
        event.preventDefault();
    }
};
// metodos principais
const updatePlataforma = async () => {
    let plataforma = {
        id: inputIdPlataforma.value,
        nome: inputPlataforma.value,
        descricao: inputDescricao.value,
    };
    let associacao = {
        plataforma_id: inputIdPlataforma.value,
        item_id: valueItens.value,
        subitem_id: valueSubItens.value,
        fornecedor_id: valueFornecedores.value,
        vl_unit_cot: parseFloat(String(vl_unit_cot.value).replace(",", ".")),
        qt_unidade_cot: qt_unidade_cot.value,
        qt_multip_uni_cot: qt_multip_uni_cot.value,
    };
    atualizarPlataforma(plataforma);
    inserirAssociacaoItemSubitemFornecedor(associacao);
    valueItens.value = null;
    valueSubItens.value = null;
    valueFornecedores.value = null;
    vl_unit_cot.value = 0;
    qt_unidade_cot.value = 1;
    qt_multip_uni_cot.value = 1;
};
const carregandoPlataformaItemSubitemFornecedor = async (id) => {
    if (!id) return;
    loading.value = true;
    PlataformaItemSubitemFornecedor.value = [];
    try {
        await axios
            .get(route("plataforma.plataformasAssociaveis", { id: id }))
            .then((res) => {
                if (res.data.success) {
                    PlataformaItemSubitemFornecedor.value = res.data.data;
                    return;
                }
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "error",
                    text: res.data.message,
                };
            })
            .catch((err) => console.error(err));
    } catch (err) {
        console.error("Erro na requisição:", err);
    } finally {
        loading.value = false;
    }
};
// carregamentos
const carregandoTodosItens = async () => {
    await axios
        .get(route("item.index"), { headers: { Accept: "application/json" } })
        .then((res) => {
            itens.value = res.data;
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 3000,
                color: "error",
                text: err,
            };
        });
};
const carregaItensSubitens = async (id) => {
    if (!id) return;
    await axios
        .get(route("item.itemAssociaveis", { id: id }))
        .then((res) => {
            if (res.data.success) {
                subItens.value = res.data.data;
                return;
            }
            feedback.value = {
                show: true,
                timeout: 3000,
                color: "error",
                text: res.data.message,
            };
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 3000,
                color: "error",
                text: err,
            };
        });
};
const carregaSubitensFornecedores = async (id) => {
    if (!id) return;
    await axios
        .get(route("subitem.subitensAssociaveis", { id: id }))
        .then((res) => {
            if (res.data.success) {
                fornecedores.value = res.data.data;
                return;
            }
            feedback.value = {
                show: true,
                timeout: 3000,
                color: "error",
                text: res.data.message,
            };
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 3000,
                color: "error",
                text: err,
            };
        });
};
// etapas de edição
const atualizarPlataforma = async (plataforma) => {
    await axios
        .put(route("plataforma.update", { id: plataforma.id }), plataforma)
        .then((res) => {
            if (res.data.success) {
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
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: err,
            };
        });
};
const inserirAssociacaoItemSubitemFornecedor = async (el) => {
    await axios
        .post("/plataformaitemsubitemfornecedor", el)
        .then((res) => {
            if (res.data.success) {
                carregandoPlataformaItemSubitemFornecedor(
                    inputIdPlataforma.value,
                );
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
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: err,
            };
        });
};
</script>

<style lang="scss" scoped></style>
