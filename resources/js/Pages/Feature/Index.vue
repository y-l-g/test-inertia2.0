<script setup lang="ts">
import FeatureItem from "@/Components/FeatureItem.vue";
import Spinner from "@/Components/Spinner.vue";
import { can } from "@/helpers";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Feature } from "@/types";
import { Head, Link, usePage, WhenVisible } from "@inertiajs/vue3";
const props = defineProps<{
  features: Feature[],
  page: number,
  lastPage: number
}>();
const user = usePage().props.auth.user
</script>

<template>

  <Head title="Features" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Features
      </h2>
    </template>
    <Link
      v-if="can(user, 'manage_features')"
      :href="route('features.create')"
      class="mb-8 inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
    >
    Create new Feature
    </Link>
    <FeatureItem
      v-for="feature in features"
      :key="feature.id"
      :feature="feature"
    ></FeatureItem>
    <WhenVisible
      v-if="page < lastPage"
      always
      :params="{
        data: {
          page: page + 1,
        },
        only: ['features', 'page'],
        preserveUrl: true
      }"
    >
      <div v-if="page < lastPage">
        <Spinner v-if="page < lastPage" />
      </div>
      <template #fallback>
        <Spinner v-if="page < lastPage" />
      </template>
    </WhenVisible>
  </AuthenticatedLayout>
</template>
