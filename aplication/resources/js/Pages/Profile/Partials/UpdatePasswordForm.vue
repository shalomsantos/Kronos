<template>
    <v-card
        title="Atualizar senha"
        text="Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura."
    >
        <v-card-item class="ma-0 pa-2">
            <form @submit.prevent="updatePassword" class="pa-2">
                <v-text-field
                    id="current_password"
                    ref="currentPasswordInput"
                    label="Senha atual"
                    v-model="form.current_password"
                    :error-messages="form.errors.current_password"
                    type="password"
                    autocomplete="current-password"
                    variant="outlined"
                    density="compact"
                />
                <v-text-field
                    id="password"
                    ref="passwordInput"
                    label="Nova senha"
                    v-model="form.password"
                    :error-messages="form.errors.password"
                    type="password"
                    autocomplete="new-password"
                    variant="outlined"
                    density="compact"
                />
                <v-text-field
                    id="password_confirmation"
                    label="Confirme a senha"
                    v-model="form.password_confirmation"
                    :error-messages="form.errors.password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    variant="outlined"
                    density="compact"
                />
                <v-btn
                    type="submit"
                    :disabled="form.processing"
                    :append-icon="form.recentlySuccessful ? 'mdi-check' : ''"
                    class="text-none w-100"
                    color="green-darken-3"
                    >Atualizar</v-btn
                >
            </form>
        </v-card-item>
    </v-card>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("password.update"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>
