<template>
    <CardGrid :items="items">
        <template #default="{ item }">
            <v-hover>
                <template v-slot:default="{ isHovering, props }">
                    <v-card
                        v-bind="props"
                        :title="item.nome"
                        prepend-icon="mdi-clipboard"
                        class="border-s-lg"
                        @click.prevent="emit('editar', item)"
                        :elevation="
                            isHovering ? 3 : 1
                        "
                    >
                        <template #subtitle>
                            <v-chip
                                size="small"
                                color="green"
                            >
                                {{ item.tipo_projeto.nome }}
                            </v-chip>
                        </template>
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
