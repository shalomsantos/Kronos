<template>
    <v-row v-if="items !== null" :dense="dense">
        <v-col
            v-for="item in items"
            :key="item[itemKey]"
            :cols="cols"
            :sm="sm"
            :lg="lg"
        >
            <slot :item="item" />
        </v-col>
    </v-row>
    <v-sheet v-else class="d-flex flex-wrap ga-2" color="transparent">
        <slot />
    </v-sheet>
</template>

<script setup>
defineProps({
    items: { type: Array, default: null },
    itemKey: { type: String, default: "id" },
    cols: { type: [Number, String], default: 12 },
    sm: { type: [Number, String], default: 6 },
    lg: { type: [Number, String], default: 4 },
    dense: { type: Boolean, default: true },
});
</script>
