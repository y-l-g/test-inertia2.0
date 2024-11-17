<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Feature, PaginatedData } from "@/types";
import { Head, router } from "@inertiajs/vue3";
const props = defineProps<{
  feature: Feature;
}>();
</script>

<template>

  <Head :title="'Feature' + feature.name" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Feature <b>{{ feature.name }}</b>
      </h2>
    </template>
    <div class="mb-4 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
      <div class="p-6 text-gray-900 dark:text-gray-100 flex gap-8">
        <div class="flex flex-col items-center">
          <button
            @click="router.post(route('features.upvote', feature.id), {}, { preserveScroll: true })"
            :class="feature.user_has_upvoted ? 'text-amber-600' : ''"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-12"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m4.5 15.75 7.5-7.5 7.5 7.5"
              />
            </svg>
          </button>
          <span
            :class="'text-2xl font-semibold' + ((feature.user_has_downvoted || feature.user_has_upvoted) && ' text-amber-600')"
          >
            {{ feature.upvote_count }}
          </span>
          <button
            @click="router.post(route('features.downvote', feature.id), {}, { preserveScroll: true })"
            :class="feature.user_has_downvoted ? 'text-amber-600' : ''"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-12"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m19.5 8.25-7.5 7.5-7.5-7.5"
              />
            </svg>

          </button>
        </div>
        <div class="flex-1">
          <h2 class="text-2xl mb-2">{{ feature.name }}</h2>
          <p>{{ feature.description }}</p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
