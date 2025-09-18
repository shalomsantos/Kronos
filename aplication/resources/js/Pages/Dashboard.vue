<template>
    <DefaultLayout
        :location="location"
        class="bg-green-lighten-5 pa-3"
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
        <v-dialog v-model="dialogNewBasezero" max-width="550">
            <v-toolbar title="Nova Base zero" density="compact"></v-toolbar>
            <v-card rounded="0">
                <v-card-item class="ma-0 pa-2">
                    <v-row dense class="pa-2">
                        <v-col cols="12" class="d-flex align-center ga-3">
                            <!-- <v-text-field clearable label="Projetos" variant="outlined" density="compact" hide-details="auto"></v-text-field> -->
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
                                prepend-icon="mdi-plus"
                                color="grey"
                                density="compact"
                                >Projeto</v-btn
                            >
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                clearable
                                label="campo 1"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                clearable
                                label="campo 1"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                clearable
                                label="campo 1"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                clearable
                                label="campo 1"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                clearable
                                label="campo 1"
                                variant="outlined"
                                density="compact"
                                hide-details="auto"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-btn class="text-none" color="grey">Salvar</v-btn>
                </v-card-item>
            </v-card>
        </v-dialog>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "../Layouts/DefaultLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const dialogFilter = ref(false);
const dialogNewBasezero = ref(false);

const location = [
    { title: "Base Zero", disabled: false, href: "/bzeros" },
    { title: "lista", disabled: true },
];
</script>

<style scoped></style>
