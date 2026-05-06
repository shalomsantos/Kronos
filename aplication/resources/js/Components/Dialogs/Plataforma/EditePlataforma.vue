<template>
    <Dialog
        v-model="model"
        title="Editar Plataforma e Modelo"
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
                            color="green-darken-3"
                            hide-details
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" class="pb-0 mb-0">
                        <v-textarea
                            v-model="inputDescricao"
                            label="Descrição"
                            variant="outlined"
                            density="compact"
                            color="green-darken-3"
                            :counter="255"
                            maxlength="255"
                            rows="3"
                            clearable
                            auto-grow
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12">
                        <v-btn
                            class="text-none w-100"
                            color="green-darken-1"
                            prepend-icon="mdi-pencil"
                            text="Editar"
                            @click.prevent="atualizar()"
                        />
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="9" class="d-flex align-end border rounded my-3">
                <v-row>
                    <v-col cols="12" class="text-center">
                        <p class="text-disabled">Aqui é possível anexar um item bem como seu subitem e fornecedor a plataforma, desta forma ao incluir a plataforma será automaticamente criado os itens aqui exibidos, este modelo de apresentação é chamado de template.</p>
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
                            color="green-darken-3"
                            hide-details
                            clearable
                        ></v-select>
                    </v-col>
                    <v-col cols="4">
                        <v-select
                            v-model="valueSubItens"
                            label="Subitem"
                            :items="subItens"
                            :disabled="!valueItens"
                            item-title="subitem.nome"
                            item-value="subitem_id"
                            variant="outlined"
                            density="compact"
                            color="green-darken-3"
                            hide-details
                            clearable
                        >
                        <template #prepend-inner v-if="!valueItens">
                            <v-icon icon="mdi-lock-outline" color="grey" size="small" class="mr-2"></v-icon>
                        </template>
                    </v-select>
                    </v-col>
                    <v-col cols="4">
                        <v-select
                            v-model="valueFornecedores"
                            label="Fornecedor"
                            :items="fornecedores"
                            :disabled="!valueSubItens"
                            item-title="fornecedor.razao_social"
                            item-value="fornecedor_id"
                            variant="outlined"
                            density="compact"
                            color="green-darken-3"
                            hide-details
                            clearable
                        >
                        <template #prepend-inner v-if="!valueSubItens">
                            <v-icon icon="mdi-lock-outline" color="grey" size="small" class="mr-2"></v-icon>
                        </template>
                    </v-select>
                    </v-col>
                    <v-col cols="4">
                        <v-text-field
                            v-model="valorUnitario"
                            label="Valor Unitário"
                            variant="outlined"
                            density="compact"
                            color="green-darken-3"
                            hide-details
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
                            color="green-darken-3"
                            hide-details
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
                            color="green-darken-3"
                            hide-details
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-btn
                            class="text-none w-100"
                            color="green-darken-1"
                            prepend-icon="mdi-invoice-text-plus"
                            text="Associar"
                            @click.prevent="associar()"
                        />
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" class="py-0">
                <v-sheet v-if="loading" color="green-lighten-5">
                    <v-skeleton-loader
                        class="mx-auto border"
                        type="table-row-divider@6"
                    ></v-skeleton-loader>
                </v-sheet>

                <v-table
                    v-else-if="PlataformaTemplate.length > 0"
                    style="height: 16rem"
                    class="overflow-y-auto rounded-lg elevation-3"
                    density="compact"
                    fixed-header
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
                            ) in PlataformaTemplate"
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
    </Dialog>
</template>

<script setup>
import { useFeedback } from "@/Composables/useFeedback";
import { ref, watch, computed } from "vue";
import Dialog from "../Dialog.vue";

const model = defineModel();
const props = defineProps({
    plataforma: Object,
});

const { trigger } = useFeedback();
const emit = defineEmits(["onCloseDialog", "editProcess"]);

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
const PlataformaTemplate = ref([]);
// feedbacks
const loading = ref(false);

watch(
    () => props.plataforma,
    (novo) => {
        if (novo) {
            inputIdPlataforma.value = novo.id ?? "";
            inputPlataforma.value = novo.nome ?? "";
            inputDescricao.value = novo.descricao ?? "";
            carregandoPlataformaTemplate(novo.id);
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
// carregamentos
const carregandoPlataformaTemplate = async (id) => {
    if (!id) return;
    loading.value = true;
    PlataformaTemplate.value = [];
    try {
        await axios
            .get(route("plataforma.plataformasAssociaveis", { id: id }))
            .then((res) => {
                if (res.data.success) {
                    PlataformaTemplate.value = res.data.data;
                    return;
                }
                trigger(res.data.message, "error");
            })
            .catch((err) => trigger(err, "error"));
    } catch (err) {
        trigger(err, "error");
    } finally {
        loading.value = false;
    }
};
const carregandoTodosItens = async () => {
    await axios
        .get(route("item.index"), { headers: { Accept: "application/json" } })
        .then((res) => {
            itens.value = res.data;
        })
        .catch((err) => {
            trigger(err, "error");
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
            trigger(res.data.message, "error");
        })
        .catch((err) => {
            trigger(err, "error");
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
            trigger(res.data.message, "error");
        })
        .catch((err) => {
            trigger(err, "error");
        });
};
// metodos principais
const atualizar = async () => {
    let plataforma = {
        id: inputIdPlataforma.value,
        nome: inputPlataforma.value,
        descricao: inputDescricao.value,
    };
    await axios
        .put(route("plataforma.update", { id: plataforma.id }), plataforma)
        .then((res) => {
            if (res.data.success) {
                trigger(res.data.message, "success");
                return;
            };
            trigger(res.data.message, "error");
        })
        .catch((err) => {
            trigger(err, "error");
        });

    cleanAll();
    emit("editProcess");
};
const associar = async () => {
    let associacao = {
        plataforma_id: inputIdPlataforma.value,
        item_id: valueItens.value,
        subitem_id: valueSubItens.value,
        fornecedor_id: valueFornecedores.value,
        vl_unit_cot: parseFloat(String(vl_unit_cot.value).replace(",", ".")),
        qt_unidade_cot: qt_unidade_cot.value,
        qt_multip_uni_cot: qt_multip_uni_cot.value,
    };

    await axios
        .post("/plataformatemplate", associacao)
        .then((res) => {
            if (res.data.success) {
                carregandoPlataformaTemplate(
                    inputIdPlataforma.value,
                );
                trigger(res.data.message, "success");
                return;
            }
            trigger(res.data.message, "error");
        })
        .catch((err) => {
            trigger(err, "error");
        });
    cleanAll();
    emit("editProcess");
};
function cleanAll() {
    valueItens.value = null;
    valueSubItens.value = null;
    valueFornecedores.value = null;
    vl_unit_cot.value = 0;
    qt_unidade_cot.value = 1;
    qt_multip_uni_cot.value = 1;
}
</script>

<style scoped></style>
