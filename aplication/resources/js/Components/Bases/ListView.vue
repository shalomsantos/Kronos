<template>
  <v-sheet class="bg-transparent">
    <v-row class="bg-transparent" v-if="dados.length > 0 && viewOption">
        <v-col cols="12" v-for="(item, id) in dados" :key="id">
            <v-hover v-slot:default="{ isHovering, props }">
                <v-card
                    v-bind="props"
                    :color="isHovering ? 'green-lighten-5' : undefined"
                    @click.prevent="openEdit(item)"
                >
                    <template #title>
                        <v-row no-gutters>
                            <v-col cols="10">
                                {{ item.nome || 'Sem nome' }}
                            </v-col>
                            <v-col cols="2" class="text-right">
                                <p class="text-body-2 text-disabled">
                                    Criado em: {{ isDate(item.created_at) }}
                                </p>
                                <p class="text-body-2 text-disabled">
                                    Por: {{ typeof item.created_by === 'object' ? item.created_by?.name : (item.created_by || 'Sistema') }}
                                </p>
                            </v-col>
                        </v-row>
                    </template>

                    <v-card-text>
                        <v-sheet class="d-flex flex-wrap ga-2 bg-transparent pt-3">
                            <template v-if="Array.isArray(item.subitens)">
                                <v-chip
                                    v-for="(sub, sId) in item.subitens"
                                    :key="sId"
                                    size="x-small" color="green" variant="flat"
                                >
                                    {{ typeof sub === 'object' ? sub.nome : sub }}
                                </v-chip>
                            </template>
                            <span v-else-if="item.subitens" class="text-caption text-disabled">
                                Possui dados vinculados
                            </span>
                        </v-sheet>
                    </v-card-text>
                </v-card>
            </v-hover>
        </v-col>
    </v-row>

    <v-table
        class="bg-green-lighten-5"
        density="compact"
        v-else-if="dados.length > 0 && !viewOption"
        striped="even"
    >
        <thead>
            <tr>
                <th class="text-left">Nome</th>
                <th class="text-left">Detalhes</th>
                <th class="text-left">Criado em</th>
                <th class="text-left">Criado por</th>
                <th class="text-left">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, id) in dados" :key="id" @click="openEdit(item)" style="cursor: pointer">
                <td>{{ item.nome }}</td>
                <td>
                    <template v-if="Array.isArray(item.subitens)">
                        <v-chip v-for="(sub, sId) in item.subitens.slice(0, 3)" :key="sId" size="x-small" class="me-1">
                            {{ typeof sub === 'object' ? sub.nome : sub }}
                        </v-chip>
                        <span v-if="item.subitens.length > 3">...</span>
                    </template>
                    <span v-else-if="typeof item.subitens === 'object' && item.subitens !== null" class="text-caption">
                         [Objeto]
                    </span>
                    <span v-else>-</span>
                </td>
                <td>{{ isDate(item.created_at) }}</td>
                <td>
                    <v-chip size="x-small" color="green" variant="flat">
                        {{ typeof item.created_by === 'object' ? item.created_by?.name : (item.created_by || 'N/A') }}
                    </v-chip>
                </td>
                <td>
                    <v-btn icon="mdi-delete" density="comfortable" color="red-lighten-2" @click.stop="deleteItem(item)"></v-btn>
                </td>
            </tr>
        </tbody>
    </v-table>

    <EmptyData v-else />
  </v-sheet>
</template>

<script setup>
import EmptyData from "@/Components/EmptyData.vue";
import { inject } from "vue";

const props = defineProps({
    dados: { type: Array, default: () => [] },
    viewOption: { type: Boolean, default: true }
});

const emit = defineEmits(['edit', 'delete']);
function openEdit(item) {
    emit('edit', item);
}

function deleteItem(item) {
    emit('delete', item);
}

function isDate(date) {
    if (!date) return "--/--/----";
    return new Date(date).toLocaleDateString("pt-BR");
}
</script>