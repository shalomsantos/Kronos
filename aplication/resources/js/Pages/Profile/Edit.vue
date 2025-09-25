<template>
    <DefaultLayout :title="'Perfil'" :location="location">
        <v-row dense>
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

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// Context Var
const location = [
    { title: "kratos", disabled: false, href: "/" },
    { title: "Perfil", disabled: true }
];
</script>


