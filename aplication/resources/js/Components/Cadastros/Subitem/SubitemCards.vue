<template>
    <CardGrid :items="items">
        <template #default="{ item }">
            <v-hover>
                <template v-slot:default="{ isHovering, props }">
                    <v-card
                        v-bind="props"
                        :title="item.nome"
                        prepend-icon="mdi-sitemap"
                        class="border-s-lg"
                        :color="isHovering ? 'green-lighten-5' : undefined"
                        @click.prevent="emit('editar', item)"
                    >
                        <template #item>
                            <v-sheet color="transparent" class="d-flex flex-column ga-3">
                                <Avatar :avatar="item" />
                                <MultItens :item="item" entity="fornecedores"/>
                            </v-sheet>
                        </template>
                    </v-card>
                </template>
            </v-hover>
        </template>
    </CardGrid>
</template>

<script setup>
import CardGrid from "@/Components/Shared/CardGrid.vue";
import Avatar from "@/Components/Bases/Avatar.vue";
import MultItens from "@/Components/Bases/MultItens.vue";

defineProps({
    items: { type: Array, required: true },
});
const emit = defineEmits(["editar"]);
</script>
