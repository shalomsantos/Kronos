<template>
  <v-snackbar v-model="data.show" :timeout="data.timeout" :color="data.color">
    {{ data.text }}

    <template v-slot:actions>
      <v-btn icon="mdi-close" variant="text" @click="data.show = false" />
    </template>
  </v-snackbar>
</template>

<script setup>
const data = defineModel() // recebe o objeto todo
</script>
