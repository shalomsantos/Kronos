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
        
        <v-app-bar color="green-lighten-5" style="height: 10vh;">
            <template v-slot:prepend>
                <v-app-bar-nav-icon color="green-darken-1"
                    @click="rail = !rail"
                ></v-app-bar-nav-icon>
            </template>
            <template v-slot:title>
                <v-sheet
                    class="d-flex align-center justify-space-between"
                    color="transparent"
                >
                    <v-breadcrumbs 
                        :items="location" 
                        color="green-darken-1"
                        active-color="green-darken-4"
                    >
                        <template v-slot:divider>
                            <v-icon
                                icon="mdi mdi-slash-forward"
                                color="green-darken-1"
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
                        <v-btn-toggle
                            v-if="props.modelValue != null"
                            :disabled="onLoad"
                            :model-value="props.modelValue"
                            @update:model-value="onViewChange"
                            class="me-3"
                            variant="outlined"
                            active-color="green-darken-4"
                            base-color="green-lighten-1"
                            divided
                            density="compact"
                            mandatory
                        >
                            <v-btn
                                :value="0"
                                variant="text"
                                title="Exibição por tabelas"
                            >
                                <v-icon icon="mdi-table"></v-icon>
                            </v-btn>

                            <v-btn
                                :value="1"
                                variant="text"
                                title="Exibição por cartões"
                            >
                                <v-icon icon="mdi-card-multiple"></v-icon>
                            </v-btn>
                        </v-btn-toggle>
                    </v-sheet>
                </v-sheet>
            </template>
        </v-app-bar>

        <v-main class="bg-green-lighten-5 overflow-x-auto pt-0" style="margin-top: 10vh; height: 90vh;">
            <v-sheet color="transparent">
                <v-row class="ma-0 pa-0">
                    <v-col cols="12">
                        <slot />
                    </v-col>
                </v-row>
            </v-sheet>
        </v-main>

        <NormalFeedback v-model="feedback" />
    </v-layout>
</template>

<script setup>
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { useFeedback } from "@/Composables/useFeedback";
import { Link, usePage, Head } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    modelValue: Number,
    title: String,
    location: {},
});

const { feedback, trigger } = useFeedback()

const onLoad = ref(false);
const user = usePage().props.auth.user;
const emit = defineEmits(["update:modelValue"]);

const drawer = ref(true);
const rail = ref(true);
const menu = ref(false);

let cadMenuOptions = [
    ["Projeto", "mdi-clipboard-file", route("projeto.index")],
    ["Plataforma", "mdi-layers", route("plataforma.index")],
    ["Item", "mdi-invoice-list", route("item.index")],
    ["Subitem", "mdi-sitemap", route("subitem.index")],
    ["Fornecedor", "mdi-store", route("fornecedor.index")],
    ["Colaborador", "mdi-apps", "/"],
    ["Intermediário", "mdi-apps", "/"],
    ["Setor", "mdi-apps", "/"],
    ["Equipe", "mdi-apps", "/"],
    ["Precificação", "mdi-apps", "/"],
];

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
                trigger(res.data.message ?? res.data, 'error')
            }
            onLoad.value = false;
        })
        .catch((err) => {
            trigger(err, 'error')
            onLoad.value = false;
        });
}
</script>
