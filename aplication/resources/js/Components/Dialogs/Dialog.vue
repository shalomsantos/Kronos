<template>
    <v-dialog v-model="model" :max-width="width ?? '90vw'" :height="height ?? '60vh'">
        <v-toolbar :title="title" density="compact"
            ><v-btn
                icon="mdi-close"
                size="small"
                @click.prevent="$emit('onCloseDialog')"
            ></v-btn
        ></v-toolbar>
        <v-card rounded="0" class="overflow-y-auto w-100 h-100">
            <v-card-item class="ma-0 pa-0">
                <v-sheet class="pa-4">
                    <slot />
                </v-sheet>
            </v-card-item>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const model = defineModel();

const props = defineProps({
    title: String,
    width: Number,
    height: Number,
});
</script>

<style scoped></style>
