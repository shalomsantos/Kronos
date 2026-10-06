<template>
    <div>
        <v-card v-for="item in plataformas" :key="item.id" class="border-s-lg mb-3">
            <template #title>
                {{ item.nome }}
                <v-divider></v-divider>
            </template>
            <template #item>
                <CardGrid class="mt-2">
                    <v-btn
                        icon="mdi-plus"
                        class="h-auto rounded"
                        min-height="160"
                        color="green-lighten-5"
                        @click.prevent="emit('adicionar', item)"
                    ></v-btn>
                    <v-card
                        v-for="itemPivot in item.itens_pivot"
                        :key="itemPivot.id"
                        min-width="300px"
                        color="green-lighten-5"
                        elevation="0"
                        border
                    >
                        <template #title>
                            <v-sheet
                                class="d-flex justify-space-between"
                                color="transparent"
                            >
                                {{ itemPivot.subitem.nome }}
                                <BzeroItemActions
                                    :item="itemPivot"
                                    @editar="emit('editar', $event)"
                                    @anexar="emit('anexar', $event)"
                                />
                            </v-sheet>
                        </template>
                        <template #subtitle>
                            {{ itemPivot.item.nome }}
                        </template>
                        <template #text>
                            {{
                                itemPivot.fornecedor?.razao_social ??
                                "Sem"
                            }}
                        </template>
                        <template #actions>
                            <v-sheet
                                class="d-flex justify-space-between w-100"
                                color="transparent"
                            >
                                <div class="d-flex ga-1">
                                    <p
                                        class="text-caption text-disabled"
                                    >
                                        R$
                                    </p>
                                    <p class="">
                                        {{
                                            itemPivot.vl_unit_cot
                                                .toString()
                                                .replace(".", ",")
                                        }}
                                    </p>
                                </div>
                                <p>{{ itemPivot.qt_unidade_cot }}</p>
                                <p>{{ itemPivot.qt_multip_uni_cot }}</p>
                                <div class="d-flex ga-1">
                                    <p
                                        class="text-caption text-disabled"
                                    >
                                        R$
                                    </p>
                                    <p class="">
                                        {{
                                            (
                                                itemPivot.vl_unit_cot *
                                                itemPivot.qt_unidade_cot *
                                                itemPivot.qt_multip_uni_cot
                                            ).toLocaleString("pt-BR", {
                                                minimumFractionDigits: 2,
                                            })
                                        }}
                                    </p>
                                </div>
                            </v-sheet>
                        </template>
                    </v-card>
                </CardGrid>
            </template>
        </v-card>
    </div>
</template>

<script setup>
import BzeroItemActions from "./BzeroItemActions.vue";
import CardGrid from "@/Components/Shared/CardGrid.vue";

defineProps({
    plataformas: { type: Array, required: true },
});
const emit = defineEmits(["editar", "adicionar", "anexar"]);
</script>
