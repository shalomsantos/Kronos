<template>
    <Dialog
        v-model="model"
        title="Nova Base zero"
        width="40vw"
        @onCloseDialog="((projetosValue=null), (ano=null), (inputDescricao=null), ($emit('onCloseDialog')))"
    >
        <v-row>
            <v-col cols="9">
                <v-combobox
                    v-model="projetosValue"
                    :items="projetosOptions"
                    item-title="nome"
                    item-value="id"
                    :return-object="false" 
                    label="Escolher ou inserir projeto"
                    color="green-darken-3"
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
                    density="compact"
                    color="green-darken-3"
                    variant="outlined"
                    hide-details="auto"
                    clearable
                ></v-text-field>
            </v-col>
            <v-col cols="12">
                <v-textarea
                    v-model="inputDescricao"
                    label="Descrição"
                    variant="outlined"
                    color="green-darken-3"
                    density="compact"
                    :counter="255"
                    maxlength="255"
                    rows="3"
                    auto-grow
                    clearable
                ></v-textarea>
            </v-col>
            <v-col cols="12">
                <v-btn
                    class="text-none"
                    color="green-darken-1"
                    prepend-icon="mdi-check"
                    text="Salvar"
                    @click.prevent="inserir"
                    />
            </v-col>
        </v-row>
    </Dialog>
    <NovoProjeto v-model="DialogNovoProjeto" @insertProcess="insertProjeto"/>
</template>

<script setup>
import NovoProjeto from "../Projeto/NovoProjeto.vue";
import { useBzero } from "@/Composables/useBzero";
import Dialog from "../Dialog.vue";
import { ref } from "vue";

const model = defineModel();

const props = defineProps({
    projetos: Object,
});

const emit = defineEmits(['onCloseDialog', 'insertEvent']);

const { inserirBzero } = useBzero();

const projetosOptions = ref(props.projetos);
const projetosValue = ref(null);
const ano = ref(null);
const inputDescricao = ref(null);
const DialogNovoProjeto = ref(false);

async function inserir() {
    try {
        const payload = {
            projeto_id: projetosValue.value,
            ano: ano.value,
            descricao: inputDescricao.value,
        };
        const res = await inserirBzero(payload); 
        emit('insertEvent', res.data);
    } catch (err) {
        emit('insertEvent', err.response?.data);
    }
}

async function insertProjeto(projeto) {
    await axios
        .post(route("projeto.store"), projeto)
        .then((res) => {
            if (res.data.success) {
                carregandoTodosProjetos();

                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "success",
                    text: res.data.message,
                };
                return;
            }
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: res.data.message,
            };
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: err,
            };
        });
}

async function carregandoTodosProjetos(termo = "") {
    await axios
        .get(route("projeto.index"), {
            params: { search: termo },
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            projetosOptions.value =  res.data; 
        })
        .catch((err) => console.log(err));
}
</script>

<style scoped></style>
