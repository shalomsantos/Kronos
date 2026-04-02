<template>
    <DefaultLayout :title="'Perfil'" :location="location">
        <v-row class="pa-2">
            <v-col cols="12">
                <p class="text-body-2">Nome</p>
                <div>
                    <p class="text-body-2 text-disabled">
                        {{ user.name }}
                    </p>
                </div>
                <p class="text-body-2">Email</p>
                <div>
                    <p class="text-body-2 text-disabled">
                        {{ user.email }}
                    </p>
                </div>
            </v-col>
            <v-col cols="12"> </v-col>
            <v-col cols="4">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                />
            </v-col>
            <v-col cols="4">
                <UpdatePasswordForm class="max-w-xl" />
            </v-col>
            <v-col cols="4">
                <DeleteUserForm class="max-w-xl" />
            </v-col>
        </v-row>
    </DefaultLayout>
</template>

<script setup>
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { usePage } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
const user = usePage().props.auth.user;
// Context Var
const location = [
    { title: "Kronos", disabled: false, href: "/" },
    { title: "Perfil", disabled: true },
];
</script>
