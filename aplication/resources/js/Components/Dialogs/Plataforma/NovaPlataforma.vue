<template>
    <v-dialog v-model="model" max-width="500">
        <v-toolbar title="Nova Plataforma" density="compact">
            <v-btn
                icon="mdi-close"
                size="small"
                @click.prevent="model=false"
            />
        </v-toolbar>
        <v-card rounded="0" class="w-100 h-100">
            <v-card-item class="ma-0 pa-2">
                <v-row class="pa-2">
                    <v-col cols="12">
                        <v-text-field
                            v-model="inputPlataforma"
                            label="Nome da plataforma*"
                            variant="outlined"
                            density="compact"
                            hide-details="auto"
                            clearable
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-textarea
                            v-model="inputDescricao"
                            label="Descrição"
                            variant="outlined"
                            density="compact"
                            rows="2"
                            clearable
                            hide-details
                            auto-grow
                            counter
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12" class="pt-3">
                        <v-btn
                            class="text-none"
                            color="green-darken-1"
                            size="large"
                            prepend-icon="mdi-plus"
                            @click.prevent="insertEvent"
                            >Adicionar</v-btn
                        >
                    </v-col>
                </v-row>
            </v-card-item>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const model = defineModel();

const inputPlataforma = ref(null);
const inputDescricao = ref(null);

const emit = defineEmits(['insertProcess']);

function insertEvent() {
    let plataforma = {
        nome: inputPlataforma.value,
        descricao: inputDescricao.value,
    };
    inputPlataforma.value = null;
    inputDescricao.value = null;
    model.value = false;
    emit('insertProcess', plataforma);
}
</script>

<style scoped></style>
