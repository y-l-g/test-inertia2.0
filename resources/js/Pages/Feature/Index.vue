<script setup lang="ts">
import FeatureItem from "@/Components/FeatureItem.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Feature, PaginatedData } from "@/types";
import { Head } from "@inertiajs/vue3";
const props = defineProps<{
  features: PaginatedData<Feature>;
}>();
</script>

<template>

  <Head title="Features" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Dashboard
      </h2>
    </template>
    <FeatureItem
      v-for="feature in features.data"
      :key="feature.id"
      :feature="feature"
    ></FeatureItem>
  </AuthenticatedLayout>
</template>
