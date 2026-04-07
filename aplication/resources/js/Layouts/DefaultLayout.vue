<template>
    <v-layout class="rounded rounded-md border">
        <Head :title="title" />

        <v-navigation-drawer
            v-model="drawer"
            permanent
            :rail="rail"
            width="190"
            color="green-darken-4"
        >
            <v-list nav density="compact">
                <v-list-item link href="/" class="text-center">
                    <template v-slot:title>
                        <v-icon
                            icon="mdi-alpha-k"
                            :style="
                                rail
                                    ? 'font-size: 2vw;'
                                    : 'transition: 250ms;font-size: 5vw;'
                            "
                        ></v-icon>
                    </template>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item
                    id="menu-activator"
                    link
                    title="Cadastro"
                    prepend-icon="mdi mdi-folder-plus"
                ></v-list-item>
                <v-menu
                    open-on-hover
                    location="end"
                    activator="#menu-activator"
                >
                    <v-list desity="compact" density="compact">
                        <v-list-item
                            v-for="([title, icon, url], i) in cadMenuOptions"
                            :key="i"
                            :prepend-icon="icon"
                            :title="title"
                            :value="title"
                            :href="url"
                            link
                        ></v-list-item>
                    </v-list>
                </v-menu>
                <v-list-item
                    title="Usuários"
                    link
                    href="/usuarios"
                    prepend-icon="mdi mdi-account-group"
                ></v-list-item>
            </v-list>
            <v-list nav density="compact">
                <v-divider></v-divider>
                <v-menu
                    v-model="menu"
                    open-on-hover
                    :close-on-content-click="false"
                    location="end"
                >
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            title="Minha conta"
                            v-bind="props"
                            prepend-icon="mdi mdi-account-circle"
                        ></v-list-item>
                    </template>
                    <v-card min-width="250">
                        <v-list>
                            <v-list-item
                                prepend-icon="mdi mdi-account"
                                :subtitle="user.email"
                                :title="user.name"
                            >
                            </v-list-item>
                        </v-list>
                        <v-divider></v-divider>
                        <v-card-actions class="d-flex justify-space-between">
                            <Link
                                :href="route('logout')"
                                method="post"
                                class="link text-decoration-none"
                            >
                                <v-chip
                                    color="green-darken-3"
                                    prepend-icon="mdi-account-arrow-right"
                                    class="px-6"
                                >
                                    Sair
                                </v-chip>
                            </Link>
                            <Link :href="route('profile.edit')" class="link">
                                <v-chip
                                    color="green-darken-3"
                                    prepend-icon="mdi-account-cog-outline"
                                    class="px-6"
                                >
                                    Perfil
                                </v-chip>
                            </Link>
                        </v-card-actions>
                    </v-card>
                </v-menu>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar density="compact" color="green-darken-3">
            <template v-slot:prepend>
                <v-app-bar-nav-icon @click="rail = !rail"></v-app-bar-nav-icon>
            </template>
            <template v-slot:title>
                <v-sheet
                    class="d-flex align-center justify-space-between"
                    color="transparent"
                >
                    <v-breadcrumbs :items="location">
                        <template v-slot:divider>
                            <v-icon
                                icon="mdi mdi-slash-forward"
                                size="x-small"
                            ></v-icon>
                        </template>
                        <template v-slot:title="{ item }">
                            <p class="text-subtitle-1">{{ item.title }}</p>
                        </template>
                    </v-breadcrumbs>
                    <v-sheet
                        class="d-flex align-center ga-3"
                        color="transparent"
                    >
                        <!-- <v-switch prepend-icon="mdi-account" hide-details color="green-lighten-4"></v-switch> -->
                        <v-btn-toggle
                            v-if="props.modelValue != null"
                            :disabled="onLoad"
                            :model-value="props.modelValue"
                            @update:model-value="onViewChange"
                            class="me-3"
                            variant="outlined"
                            divided
                            mandatory
                        >
                            <v-btn :value="0" class="text-white" density="compact" title="Exibição por tabelas">
                                <v-icon icon="mdi-table"></v-icon>
                            </v-btn>

                            <v-btn :value="1" class="text-white" density="compact" title="Exibição por cartões">
                                <v-icon icon="mdi-card-multiple"></v-icon>
                            </v-btn>
                        </v-btn-toggle>
                    </v-sheet>
                </v-sheet>
            </template>
        </v-app-bar>

        <v-main class="bg-green-lighten-5" min-height="97vh">
            <v-sheet color="transparent" class="pa-2">
                <slot />
            </v-sheet>
        </v-main>

        <NormalFeedback v-model="feedback" />
    </v-layout>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { Link, usePage, Head } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    modelValue: Number,
    title: {
        type: String,
        default: "None",
    },
    location: {},
});
const onLoad = ref(false);
const user = usePage().props.auth.user;
const emit = defineEmits(["update:modelValue"]);

const drawer = ref(true);
const rail = ref(false);
const menu = ref(false);

let cadMenuOptions = [
    ["Projeto", "mdi-apps", route("projeto.index")],
    ["Plataforma", "mdi-apps", route("plataforma.index")],
    ["Item", "mdi-apps", route("item.index")],
    ["Subitem", "mdi-apps", route("subitem.index")],
    ["Fornecedor", "mdi-apps", route("fornecedor.index")],
    ["Colaborador", "mdi-apps", "/"],
    ["Intermediário", "mdi-apps", "/"],
    ["Setor", "mdi-apps", "/"],
    ["Equipe", "mdi-apps", "/"],
    ["Precificação", "mdi-apps", "/"],
];
// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});

async function onViewChange(value) {
    onLoad.value = true;

    let data = {
        user_id: user.id,
        listagem_menu: value,
    };

    await axios
        .post(route("preferencia.modify"), data)
        .then((res) => {
            if (res.data.success) {
                emit("update:modelValue", value);
            } else {
                feedback.value = {
                    show: true,
                    timeout: 4000,
                    color: "error",
                    text: res.data.message ?? res.data,
                };
            }
            onLoad.value = false;
        })
        .catch((err) => {
            feedback.value = {
                show: true,
                timeout: 4000,
                color: "error",
                text: err,
            };
            onLoad.value = false;
        });
}
</script>
