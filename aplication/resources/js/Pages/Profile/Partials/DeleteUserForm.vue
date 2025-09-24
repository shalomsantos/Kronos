<template>
    <v-card
        title="Deletar minha conta"
        text="Após a exclusão da sua conta, todos os seus recursos e dados serão excluídos permanentemente. Digite sua senha para confirmar que deseja excluir sua conta permanentemente."
    >
        <v-card-item>
            <v-btn class="text-none" color="red-darken-1" @click="dialog = true"
                >Deletar</v-btn
            >
            <v-dialog v-model="dialog" width="auto">
                <v-card
                    max-width="500"
                    title="Tem certeza de que deseja excluir sua conta?"
                    text="Após a exclusão da sua conta, todos os seus recursos e dados serão excluídos permanentemente. Digite sua senha para confirmar que deseja excluir sua conta permanentemente."
                >
                    <v-card-item>
                        <v-text-field
                            id="password"
                            ref="passwordInput"
                            label="Digite a senha"
                            v-model="form.password"
                            :error-messages="form.errors.password"
                            @keyup.enter="deleteUser"
                            type="password"
                            autocomplete="current-password"
                            variant="solo-filled"
                            density="compact"
                        />
                    </v-card-item>
                    <template v-slot:actions>
                        <v-btn
                            class="text-none"
                            color="red-darken-1"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="deleteUser"
                        >
                            Deletar conta
                        </v-btn>
                        <v-btn
                            class="ms-auto text-none"
                            text="Cancelar"
                            @click="dialog = false"
                        ></v-btn>
                    </template>
                </v-card>
            </v-dialog>
        </v-card-item>
    </v-card>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref(null);

const form = useForm({
    password: "",
});

const dialog = ref(false);

const deleteUser = () => {
    form.delete(route("profile.destroy"), {
        preserveScroll: true,
        onSuccess: () => (dialog.value = false),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};
</script>
