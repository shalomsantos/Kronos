<template>
    <Dialog
        v-model="model"
        title="Incluir Item"
        width="50vw"
        @onCloseDialog="$emit('onCloseDialog')"
    >
        <v-row>
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
    </Dialog>
</template>

<script setup>
import { ref, watch, computed, onMounted } from "vue";
import Dialog from "../Dialog.vue";
import axios from "axios";
const model = defineModel();

const emit = defineEmits(['onCloseDialog', 'incluirProcess']);

const valueItens = ref(null);
const itens = ref([]);

const valueSubItens = ref(null);
const subItens = ref([]);

const valueFornecedores = ref(null);
const fornecedores = ref([]);

const vl_unit_cot = ref(0);
const qt_unidade_cot = ref(1);
const qt_multip_uni_cot = ref(1);

onMounted(() => {
    carregandoTodosItens()
})

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
</script>

<style scoped></style>
