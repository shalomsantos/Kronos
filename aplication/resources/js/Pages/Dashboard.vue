<template>
    <DefaultLayout
        :location="location"
        @filter="dialogFilter = !dialogFilter"
        @newBasezero="dialogNewBasezero = !dialogNewBasezero"
    >
        <h1 class="text-h1">dashboard</h1>

        <v-dialog v-model="dialogFilter" max-width="480">
            <v-card
                title="lorem ipsum"
                subtitle="lorem ipsum lorem ipsum"
                text="lorem ipsumlorem ipsum"
            ></v-card>
        </v-dialog>
        <v-dialog v-model="dialogNewBasezero" max-width="650">
            <v-toolbar title="Nova Base zero" density="compact"><v-btn icon="mdi-close" @click.prevent="dialogNewBasezero=false"></v-btn></v-toolbar>
            <v-card rounded="0">
                <v-card-item class="ma-0 pa-2">
                    <v-row dense class="pa-2">
                        <v-col cols="9" class="d-flex ga-2 align-center">
                            <v-select
                                clearable
                                label="Projetos"
                                :items="[
                                    'California',
                                    'Colorado',
                                    'Florida',
                                    'Georgia',
                                    'Texas',
                                    'Wyoming',
                                ]"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                            ></v-select>
                            <v-btn
                                class="text-none"
                                :href="route('projeto.index')"
                                prepend-icon="mdi-plus"
                                color="green-darken-1"
                            >Projeto</v-btn>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field
                                label="Ano"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea
                                clearable
                                label="Descrição"
                                variant="outlined"
                                density="compact"
                                hide-details
                                rows="2"
                                auto-grow
                                counter
                            ></v-textarea>
                        </v-col>
                        <v-btn class="text-none" color="green-darken-1">Salvar</v-btn>
                    </v-row>
                </v-card-item>
            </v-card>
        </v-dialog>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { ref } from "vue";
import { usePage } from '@inertiajs/vue3'
import { Link } from "@inertiajs/vue3";

const page = usePage()
const pageInfo = page.props;
const dialogFilter = ref(false);
const dialogNewBasezero = ref(false);

const location = [
    { title: "Base Zero", disabled: false, href: "/" },
    { title: "lista", disabled: true },
];
</script>

<style scoped></style>
