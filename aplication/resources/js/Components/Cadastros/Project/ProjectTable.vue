<template>
    <TableShell>
        <thead>
            <tr>
                <th class="text-left">Nome</th>
                <th class="text-left">Tipo</th>
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
                <td>{{ item.tipo_projeto.nome }}</td>
                <td style="width: 200px;">
                    <Avatar :avatar="item"/>
                </td>
                <td>
                    <v-btn
                        disabled
                        class="text-none me-1"
                        icon="mdi-delete"
                        density="comfortable"
                        color="red-lighten-2"
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
const emit = defineEmits(["editar"]);
</script>
