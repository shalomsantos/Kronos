<template>
    <DefaultLayout :location="location">
        <v-card>
            <v-card-item>
                <v-btn
                    @click.prevent="dialogNewProjeto = true"
                    class="text-none"
                    color="green-darken-1"
                    >Novo</v-btn
                >
            </v-card-item>
        </v-card>
        <v-sheet class="bg-transparent">
            <v-table density="compact" v-if="desserts.length > 0">
                <thead>
                    <tr>
                        <th class="text-left">Name</th>
                        <th class="text-left">Calories</th>
                        <th class="text-left">***</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in desserts" :key="item.name">
                        <td>{{ item.name }}</td>
                        <td>{{ item.calories }}</td>
                        <td>
                            <v-btn
                                class="text-none me-1"
                                icon="mdi-delete"
                                density="comfortable"
                                color="red-lighten-2"
                            ></v-btn>
                            <v-btn
                                class="text-none"
                                icon="mdi-pencil"
                                density="comfortable"
                                color="indigo-lighten-2"
                            ></v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
            <EmptyData v-else />
        </v-sheet>

        <!-- Dialogs -->
        <NovoProjeto v-model="dialogNewProjeto"></NovoProjeto>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import NovoProjeto from "@/Components/Dialogs/NovoProjeto.vue";
import EmptyData from "@/Components/EmptyData.vue";
import { ref } from "vue";

// Context Var
const location = [
    { title: "Base Zero", disabled: false, href: "/" },
    { title: "Projetos", disabled: true },
    { title: "Todos", disabled: true },
];

// dialogs
const dialogNewProjeto = ref(false);

const desserts = [
    {
        name: "Frozen Yogurt",
        calories: 159,
    },
    {
        name: "Ice cream sandwich",
        calories: 237,
    },
    {
        name: "Eclair",
        calories: 262,
    },
    {
        name: "Cupcake",
        calories: 305,
    },
    {
        name: "Gingerbread",
        calories: 356,
    },
    {
        name: "Jelly bean",
        calories: 375,
    },
    {
        name: "Lollipop",
        calories: 392,
    },
    {
        name: "Honeycomb",
        calories: 408,
    },
    {
        name: "Donut",
        calories: 452,
    },
    {
        name: "KitKat",
        calories: 518,
    },
];
</script>

<style scoped></style>
