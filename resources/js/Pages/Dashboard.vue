<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Dashboard
      </h2>
    </template>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
      <div class="p-6 text-gray-900 dark:text-gray-100">
        You're logged in!
      </div>
    </div>
  </AuthenticatedLayout>
</template>
