<template>
    <Dialog
        v-model="model"
        width="30vw"
        :title="title"
        @onCloseDialog="model = false"
    >
        <v-row>
            <v-col cols="12" align="center">
                <v-icon icon="mdi-alert-circle" color="warning"></v-icon>
                <p class="text-disabled">{{ subtitle }}</p>
            </v-col>
            <v-col cols="12" class="d-flex justify-space-between">
                <v-btn
                    color="success"
                    prepend-icon="mdi-check"
                    @click.prevent="$emit('confirmed')"
                    text="Confirmar"
                />
                <v-btn
                    color="red"
                    prepend-icon="mdi-close"
                    @click.prevent="$emit('canceled')"
                    text="Cancelar"
                />
            </v-col>
        </v-row>
    </Dialog>
</template>

<script setup>
import Dialog from "./Dialog.vue";

const model = defineModel();

const props = defineProps({
    title: {
        type: String,
        default: "Confirmação",
    },
    subtitle: {
        type: String,
        default:
            "Por favor! Confirme a ação para prosseguir com as atividades.",
    },
});
const emit = defineEmits(["confirmed", "canceled"]);
</script>

<style scoped></style>
