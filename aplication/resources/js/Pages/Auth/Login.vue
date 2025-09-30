<template>
    <v-row no-gutters class="bg-grey-lighten-4 ma-0 pa-0">
        <Head title="Login"></Head>


        <v-col cols="3" class="mx-auto" style="margin-top: 7.2rem;">
            <form @submit.prevent="submit" class="d-flex flex-column position-relative px-3 py-6">
                <h1 class="work-sans text-center mb-3">Kratos</h1>
                <v-icon icon="mdi-omega" class="position-absolute"></v-icon>
                <v-text-field
                    type="email"
                    label="E-mail"
                    v-model="form.email"
                    variant="outlined"
                    :error-messages="form.errors.email"
                    autofocus
                    required
                ></v-text-field>

                <v-text-field
                    type="password"
                    label="Senha"
                    v-model="form.password"
                    variant="outlined"
                    :error-messages="form.errors.password"
                    required
                    autocomplete="current-password"
                ></v-text-field>

                <v-btn
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    size="x-large"
                    class="text-none mb-3"
                    color="green-darken-3"
                >
                    Entrar
                </v-btn>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-black text-decoration-none"
                >
                    Esqueceu a sua senha?
                </Link>
            </form>
        </v-col>
    </v-row>
</template>

<script setup>
import { Link, useForm, Head } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<style scoped>
.position-absolute{
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 40rem;
    color: rgba(128, 128, 128, 0.322);
}
.text-black{
    color: #609dff !important;
}
.text-black:hover{
    color: #396ec3 !important;
}
</style>
