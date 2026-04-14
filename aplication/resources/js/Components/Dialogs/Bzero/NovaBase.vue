<template>
    <Dialog
        v-model="model"
        title="Nova Base zero"
        width="40vw"
        @onCloseDialog="((projetosValue=null), (ano=null), (inputDescricao=null), ($emit('onCloseDialog')))"
    >
        <v-row>
            <v-col cols="9" class="d-flex ga-2 align-center">
                <v-combobox
                    v-model="projetosValue"
                    :items="projetos"
                    item-title="nome"
                    item-value="id"
                    :return-object="false" 
                    label="Escolher ou inserir projeto"
                    variant="outlined"
                    density="compact"
                    hide-details
                    clearable
                >
                    <template v-slot:prepend-item>
                        <v-divider></v-divider>
                        <v-list-item
                            title="Não encontrou?"
                            subtitle="Clique para cadastrar um novo"
                            prepend-icon="mdi-plus-circle-outline"
                            @click.prevent="DialogNovoProjeto=true"
                            color="primary"
                        >
                        </v-list-item>
                        <v-divider></v-divider>
                    </template>

                    <template v-slot:no-data>
                        <v-list-item
                            title="Nenhum item encontrado"
                            subtitle="Clique aqui para criar um novo"
                        ></v-list-item>
                    </template>
                </v-combobox>
            </v-col>
            <v-col cols="3">
                <v-text-field
                    v-model="ano"
                    label="Ano"
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
                    clearable
                    hide-details
                    rows="2"
                    auto-grow
                    counter
                ></v-textarea>
            </v-col>
            <v-col cols="12" class="pt-3">
                <v-btn
                    class="text-none"
                    color="green-darken-1"
                    prepend-icon="mdi-content-save"
                    @click.prevent="((console.log(projetosValue)))"
                    >Salvar</v-btn
                >
            </v-col>
        </v-row>
    </Dialog>
    <NovoProjeto v-model="DialogNovoProjeto" @insertProcess="insertProjeto"/>
</template>

<script setup>
import NovoProjeto from "../Projeto/NovoProjeto.vue";
import Dialog from "../Dialog.vue";
import { ref } from "vue";

const model = defineModel();
const emit = defineEmits(["onCloseDialog"]);

const props = defineProps({
    projetos: Object,
});

const projetosValue = ref(null);
const ano = ref(null);
const inputDescricao = ref(null);
const DialogNovoProjeto = ref(false);

function insertProjeto(projeto) {
    
}
</script>

<style scoped></style>
