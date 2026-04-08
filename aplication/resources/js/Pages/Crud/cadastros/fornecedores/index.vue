<template>
    <DefaultLayout
        v-model="viewOption"
        :title="'fornecedores lista'"
        :location="location"
    >
        <v-row>
            <v-col class="d-flex ga-3" cols="12">
                <v-btn
                    @click.prevent="dialogNovoItem = true"
                    class="text-none"
                    color="green-darken-1"
                    prepend-icon="mdi-plus"
                    text="Adicionar"
                />
                <v-text-field
                    v-model="search"
                    placeholder="Pesquisar aqui..."
                    variant="outlined"
                    density="compact"
                    hide-details="auto"
                    clearable
                />
            </v-col>
            <v-col
                cols="6"
                v-for="(item, id) in fornecedoresFiltrados"
                :key="id"
                v-if="fornecedoresFiltrados.length > 0 && viewOption"
            >
                <v-hover>
                    <template v-slot:default="{ isHovering, props }">
                        <v-card
                            v-bind="props"
                            :title="item.razao_social"
                            :color="isHovering ? 'green-lighten-5' : undefined"
                            @click.prevent="
                                ((itemSelecionado = item),
                                (dialogEditeItem = true))
                            "
                        >
                            <template v-slot:prepend>
                                <v-icon
                                    icon="mdi-store"
                                    color="green-darken-1"
                                ></v-icon>
                            </template>
                            <template #subtitle>
                                <p class="text-body-2 text-disabled">
                                    Criado em:
                                    {{ isDate(item.created_at) }}
                                </p>
                                <p class="text-body-2 text-disabled">
                                    Por: {{ item.created_by.name }}
                                </p>
                            </template>
                        </v-card>
                    </template>
                </v-hover>
            </v-col>
            <v-col
                cols="12"
                v-else-if="fornecedoresFiltrados.length > 0 && !viewOption"
            >
                <v-table
                    class="bg-green-lighten-5"
                    density="compact"
                    striped="even"
                >
                    <thead>
                        <tr>
                            <th class="text-left">Nome</th>
                            <th class="text-left">Criado em</th>
                            <th class="text-left">Criado por</th>
                            <th class="text-left">***</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, id) in fornecedoresFiltrados"
                            :key="id"
                            @click.prevent="
                                ((projetoSelecionado = item),
                                (dialogEditProjeto = true))
                            "
                        >
                            <td>{{ item.razao_social }}</td>
                            <td>{{ isDate(item.created_at) }}</td>
                            <td>
                                <v-chip
                                    size="x-small"
                                    color="green"
                                    variant="flat"
                                >
                                    {{ item.created_by.name }}
                                </v-chip>
                            </td>
                            <td>
                                <v-btn
                                    class="text-none me-1"
                                    icon="mdi-delete"
                                    density="comfortable"
                                    color="red-lighten-2"
                                ></v-btn>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-col>
            <v-col cols="12" v-else>
                <EmptyData />
            </v-col>
            <v-col cols="12">
                <v-pagination
                    v-model="fornecedores.current_page"
                    :length="fornecedores.last_page"
                    :total-visible="4"
                    @update:model-value="updatePage"
                    class="position-absolute bottom-0 mb-3"
                    style="left: 50%; transform: translateX(-50px); z-index: 15"
                    active-color="green-darken-4"
                    color="green-lighten-1"
                    density="comfortable"
                    variant="flat"
                ></v-pagination>
            </v-col>
        </v-row>
        <NormalFeedback v-model="feedback"></NormalFeedback>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EmptyData from "@/Components/EmptyData.vue";
import NormalFeedback from "@/Components/Feedback/NormalFeedback.vue";
import { router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    fornecedores: Object,
    user: Object,
    preferencias: Object,
});

const viewOption = ref(props.preferencias?.listagem_menu ?? 0);
const search = ref("");

const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Fornecedores", disabled: true },
    { title: "Lista", disabled: true },
];

const fornecedoresFiltrados = computed(() => {
    if (!search.value) {
        return props.fornecedores.data;
    }

    const termo = search.value.toLowerCase();

    return props.fornecedores.data.filter((item) => {
        const razao = item.razao_social?.toLowerCase() || "";
        const nome = item.nome?.toLowerCase() || "";

        return razao.includes(termo) || nome.includes(termo);
    });
});

const updatePage = (page) => {
    router.get(
        route("fornecedor.index"),
        { page: page },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

// Feedback var
const feedback = ref({
    show: false,
    timeout: 2000,
    color: "success",
    text: "",
});
</script>

<style scoped></style>
