<template>
    <slot v-if="mode === 0" name="table" />
    <slot v-else-if="mode === 1" name="cards" />
</template>

<script setup>
defineProps({
    mode: { type: Number, required: true },
});
</script>
