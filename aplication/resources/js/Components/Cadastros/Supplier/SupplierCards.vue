<template>
    <CardGrid :items="items">
        <template #default="{ item }">
            <v-hover>
                <template v-slot:default="{ isHovering, props }">
                    <v-card
                        v-bind="props"
                        :title="item.razao_social"
                        prepend-icon="mdi-store"
                        class="border-s-lg"
                        :elevation="isHovering ? 3 : 1"
                        @click.prevent="emit('editar', item)"
                    >
                        <template #item>
                            <Avatar :avatar="item"/>
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

defineProps({
    items: { type: Array, required: true },
});
const emit = defineEmits(["editar"]);
</script>
