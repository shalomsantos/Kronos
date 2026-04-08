<template>
    <Head title="Login"></Head>

    <v-container fluid class="pa-0" style="height: 100vh; overflow: hidden">
        <v-row no-gutters class="fill-height">
            <v-col
                cols="12"
                md="6"
                class="d-flex align-center justify-center bg-white"
            >
                <v-card flat max-width="400" width="100%" class="pa-4">
                    <v-card-title
                        class="text-h4 font-weight-bold text-green-darken-3 mb-6 text-center"
                    >
                        Kronos
                    </v-card-title>

                    <v-card-text>
                        <form
                            @submit.prevent="submit"
                            class="d-flex flex-column ga-4"
                        >
                            <v-text-field
                                type="email"
                                label="E-mail"
                                v-model="form.email"
                                variant="outlined"
                                :error-messages="form.errors.email"
                                autofocus
                                required
                                hide-details="auto"
                                color="green-darken-3"
                            ></v-text-field>

                            <v-text-field
                                type="password"
                                label="Senha"
                                v-model="form.password"
                                variant="outlined"
                                :error-messages="form.errors.password"
                                required
                                autocomplete="current-password"
                                hide-details="auto"
                                color="green-darken-3"
                            ></v-text-field>

                            <v-btn
                                type="submit"
                                :loading="form.processing"
                                :disabled="form.processing"
                                size="x-large"
                                class="text-none mt-4 w-100"
                                color="green-darken-3"
                                rounded="lg"
                            >
                                Entrar
                            </v-btn>

                            <div class="text-center mt-4">
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-grey-darken-1 text-decoration-none text-caption"
                                >
                                    Esqueceu a sua senha?
                                </Link>
                            </div>
                        </form>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col
                cols="12"
                md="6"
                class="bg-green-darken-4 d-none d-md-flex align-center justify-center"
            >
                <div class="text-center">
                    <v-icon size="150" color="white"
                        >mdi-clock-outline</v-icon
                    >
                    <h2 class="text-h2 text-white font-weight-thin">Kronos</h2>
                </div>
            </v-col>
        </v-row>
    </v-container>
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
.position-absolute {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 40rem;
    color: rgba(128, 128, 128, 0.322);
}
.text-black {
    color: #609dff !important;
}
.text-black:hover {
    color: #396ec3 !important;
}
</style>
