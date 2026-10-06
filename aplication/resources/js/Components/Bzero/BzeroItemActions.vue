<template>
    <v-menu location="top">
        <template #activator="{ props }">
            <v-btn
                v-bind="props"
                icon="mdi-dots-vertical"
                variant="text"
                density="compact"
            />
        </template>
        <v-list density="compact">
            <v-list-item
                title="Anexar"
                prepend-icon="mdi-tag"
                @click="emit('anexar', item)"
            />
            <v-list-item
                title="Editar"
                prepend-icon="mdi-pencil"
                @click="emit('editar', item)"
            />
        </v-list>
    </v-menu>
</template>

<script setup>
defineProps({
    item: { type: Object, required: true },
});
const emit = defineEmits(["editar", "anexar"]);
</script>
