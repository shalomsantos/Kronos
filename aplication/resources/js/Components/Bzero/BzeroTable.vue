<template>
    <div>
        <v-row
            no-gutters
            class="bg-grey-lighten-4 pa-2 d-none d-md-flex"
        >
            <v-col cols="2">Item</v-col>
            <v-col cols="2">Subitem</v-col>
            <v-col cols="2">Fornecedor</v-col>
            <v-col cols="1" class="text-right">Vl. unit.</v-col>
            <v-col cols="1" class="text-center">Qtd.</v-col>
            <v-col cols="1" class="text-center">Mult.</v-col>
            <v-col cols="1" class="text-right">Total</v-col>
            <v-col class="text-right"></v-col>
        </v-row>

        <v-sheet
            v-for="plataforma in plataformas"
            :key="plataforma.id"
            class="border mb-3"
        >
            <v-row no-gutters>
                <v-col cols="12" class="d-flex align-center ga-3 bg-green-lighten-5">
                    <v-btn
                        icon="mdi-plus"
                        class="rounded"
                        density="comfortable"
                        color="green-lighten-5"
                        @click.prevent="emit('adicionar', plataforma)"
                    ></v-btn>
                    <h4 class="text-green-darken-3">
                        <v-icon
                            icon="mdi-layers-outline"
                            start
                        ></v-icon>
                        {{ plataforma.nome }}
                    </h4>
                </v-col>
            </v-row>

            <v-row
                v-for="itemPivot in plataforma.itens_pivot"
                :key="itemPivot.id"
                no-gutters
                class="bg-grey-lighten-4 align-center pa-2"
            >
                <v-col cols="12" md="2" class="text-truncate">
                    {{ itemPivot.item.nome }}
                </v-col>
                <v-col cols="12" md="2" class="text-truncate">
                    {{ itemPivot.subitem.nome }}
                </v-col>
                <v-col
                    cols="12"
                    md="2"
                    class="text-truncate text-grey-darken-1"
                >
                    {{ itemPivot.fornecedor?.razao_social }}
                </v-col>
                <v-col cols="3" md="1" class="text-right">
                    R$
                    {{
                        itemPivot.vl_unit_cot
                            .toString()
                            .replace(".", ",")
                    }}
                </v-col>
                <v-col cols="3" md="1" class="text-center">
                    {{ itemPivot.qt_unidade_cot }}
                </v-col>
                <v-col cols="3" md="1" class="text-center">
                    {{ itemPivot.qt_multip_uni_cot }}
                </v-col>
                <v-col cols="3" md="1" class="text-right">
                    R$
                    {{
                        (
                            itemPivot.vl_unit_cot *
                            itemPivot.qt_unidade_cot *
                            itemPivot.qt_multip_uni_cot
                        ).toLocaleString("pt-BR", {
                            minimumFractionDigits: 2,
                        })
                    }}
                </v-col>
                <v-col class="ps-4">
                    <BzeroItemActions :item="itemPivot" @editar="emit('editar', $event)" @anexar="emit('anexar', $event)" />
                </v-col>
            </v-row>
        </v-sheet>
    </div>
</template>

<script setup>
import BzeroItemActions from "./BzeroItemActions.vue";

defineProps({
    plataformas: { type: Array, required: true },
});
const emit = defineEmits(["editar", "adicionar", "anexar"]);
</script>
