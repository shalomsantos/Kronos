<template>
    <v-dialog v-model="model" max-width="90vw" height="90vh">
        <v-card rounded="0" class="overflow-y-hidden w-100 h-100">
            <v-toolbar title="Edição da plataforma" density="compact">
                <v-btn
                    icon="mdi-close"
                    size="small"
                    @click.prevent="model = false"
                />
            </v-toolbar>
            <v-card-item class="d-flex ma-0 pa-0">
                <v-row class="px-4 pt-4">
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
                                    Associe o item novo à plataforma
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
                                    label="Valor Unitário"
                                    variant="outlined"
                                    density="compact"
                                    hide-details="auto"
                                    prefix="R$"
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
                <v-row class="px-4">
                    <v-col cols="12">
                        <v-sheet v-if="loading" color="green-lighten-5">
                            <v-skeleton-loader
                                class="mx-auto border"
                                type="table-row-divider@6"
                            ></v-skeleton-loader>
                        </v-sheet>

                        <v-table
                            v-else-if="relationchips.length > 0"
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, id) in relationchips"
                                    :key="id"
                                >
                                    <td>{{ item.item.nome }}</td>
                                    <td>{{ item.subitem.nome }}</td>
                                    <td>{{ item.fornecedor.razao_social }}</td>
                                    <td>{{ item.vl_unit_cot }}</td>
                                    <td>{{ item.qt_unidade_cot }}</td>
                                    <td>{{ item.qt_multip_uni_cot }}</td>
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
            </v-card-item>
        </v-card>
        <!-- Feedback -->
        <NormalFeedback v-model="feedback" />
    </v-dialog>
</template>

<script setup>
const model = defineModel();
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { ref, watch } from "vue";

const props = defineProps({
    plataformaSelecionada: {
        type: Object,
    },
});

// selects on load choose and normals inputs
const inputPlataforma = ref(""); // normais
const inputDescricao = ref(""); // normais
const valueItens = ref(null);
const itens = ref([]);
const valueSubItens = ref(null);
const subItens = ref([]);
const valueFornecedores = ref(null);
const fornecedores = ref([]);
const valor = ref(1); // normais
// dados
const relationchips = ref([]);
// feedbacks
const loading = ref(false);
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

watch(
    () => props.plataformaSelecionada,
    (novo) => {
        if (novo) {
            inputPlataforma.value = novo.nome ?? "";
            inputDescricao.value = novo.descricao ?? "";
            loadPlataformaItemSubitemFornecedor(novo.id);
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
        } else if(novo == null){
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
        } else if(novo == null){
            fornecedores.value = [];
            valueFornecedores.value = null;
        }
    },
    { immediate: true },
);

const incluirAssociacaoItensSubitensForncedor = () => {
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
}
const loadPlataformaItemSubitemFornecedor = async (id) => {
    if (!id) return;
    loading.value = true;
    relationchips.value = [];
    try {
        await axios
            .get(route("plataforma.plataformasAssociaveis", { id: id }))
            .then((res) => {
                if (res.data.success) {
                    relationchips.value = res.data.data;
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
}
const carregandoTodosItens = async () => {
    await axios
        .get(route("item.index"), { headers: { Accept: "application/json" } })
        .then((res) => {
            if(res.data.success){
                itens.value = res.data.data;
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
const carregaItensSubitens = async (id) => {
    if (!id) return;
    await axios
        .get(route("item.itemAssociaveis", { id: id }))
        .then((res) => {
            if(res.data.success){
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
}
const carregaSubitensFornecedores = async (id) => {
    if (!id) return;
    await axios
        .get(route("subitem.subitensAssociaveis", { id: id }))
        .then((res) => {
            if(res.data.success){
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
}
</script>

<style lang="scss" scoped></style>
