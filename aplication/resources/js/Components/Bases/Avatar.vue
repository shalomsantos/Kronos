<template>
    <v-tooltip :text="nomeCompleto" location="top">
        <template v-slot:activator="{ props }">
            <v-avatar v-bind="props" color="green-darken-1" density="compact">
                <span class="text-headline-small">{{
                    avatarNick(nomeCompleto)
                }}</span>
            </v-avatar>
        </template>
    </v-tooltip>
</template>

<script setup>
const props = defineProps({
    nomeCompleto: String,
});
</script>

<style scoped></style>
