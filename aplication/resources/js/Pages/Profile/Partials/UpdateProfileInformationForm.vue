<template>
    <v-card title="Informações do perfil" text="Atualize as informações do perfil e o endereço de e-mail da sua conta.">
        <v-card-item class="ma-0 pa-2">
            <form
                @submit.prevent="form.patch(route('profile.update'))"
                class="pa-2"
            >
                <v-text-field
                    id="name"
                    type="text"
                    label="Nome"
                    variant="outlined"
                    v-model="form.name"
                    :error-messages="form.errors.name"
                    required
                    autofocus
                    autocomplete="name"
                    density="compact"
                />
                <v-text-field
                    id="email"
                    type="email"
                    label="Email"
                    variant="outlined"
                    v-model="form.email"
                    :error-messages="form.errors.email"
                    required
                    autocomplete="username"
                    density="compact"
                />
                <v-btn
                    type="submit"
                    :disabled="form.processing"
                    :append-icon="form.recentlySuccessful ? 'mdi-check' : ''"
                    class="text-none w-100"
                    color="green-darken-3"
                    >Salvar</v-btn
                >
            </form>
        </v-card-item>
    </v-card>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>
