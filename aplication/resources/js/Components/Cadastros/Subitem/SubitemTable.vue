<template>
    <TableShell>
        <thead>
            <tr>
                <th class="text-left">Nome</th>
                <th class="text-left">Subitens</th>
                <th class="text-center">Por</th>
                <th class="text-left"></th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="item in items"
                :key="item.id"
                @click.prevent="emit('editar', item)"
            >
                <td>{{ item.nome }}</td>
                <td>
                    <v-chip
                        v-for="(
                            fornecedor, idx
                        ) in item.fornecedores.slice(0, 2)"
                        :key="idx"
                        size="x-small"
                        color="green-darken-1"
                        variant="tonal"
                        class="font-weight-bold"
                    >
                        {{ fornecedor.razao_social }}
                    </v-chip>
                    <a
                        v-if="item.fornecedores.length > 2"
                        size="x-small"
                        variant="text"
                        class="text-grey-darken-1"
                    >
                        +{{ item.fornecedores.length - 2 }} itens
                    </a>
                </td>
                <td style="width: 200px;">
                    <Avatar :avatar="item"/>
                </td>
                <td>
                    <v-btn
                        class="text-none me-1"
                        icon="mdi-delete"
                        density="comfortable"
                        color="red-lighten-2"
                        @click.prevent="emit('excluir', item)"
                    ></v-btn>
                </td>
            </tr>
        </tbody>
    </TableShell>
</template>

<script setup>
import TableShell from "@/Components/Shared/TableShell.vue";
import Avatar from "@/Components/Bases/Avatar.vue";

defineProps({
    items: { type: Array, required: true },
});
const emit = defineEmits(["editar", "excluir"]);
</script>
