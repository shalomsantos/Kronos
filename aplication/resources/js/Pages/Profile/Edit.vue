<template>
    <DefaultLayout :title="'Perfil'" :location="location">
        <v-row>
            <v-col cols="12">
                <p>{{ user.name }}</p>
                <p>{{ user.email }}</p>
            </v-col>
            <v-col cols="12">

            </v-col>
        </v-row>
        <v-row>
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
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
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
    { title: "Perfil", disabled: true }
];
</script>


