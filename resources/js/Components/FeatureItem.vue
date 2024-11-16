<script setup lang="ts">
import { Feature } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
  feature: Feature;
}>();

const isExpanded = ref(false);
const toggleReadMore = () => {
  isExpanded.value = !isExpanded.value
}
</script>

<template>
  <div class="mb-4 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
    <div class="p-6 text-gray-900 dark:text-gray-100 flex gap-8">
      <div class="flex flex-col items-center">
        <button>
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
        <span class="text-2xl font-semibold">
          12
        </span>
        <button>
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

        <h2 class="text-2xl mb-2">
          <Link :href="route('features.show', feature)">{{ feature.name }}</Link>
        </h2>

        <div v-if="(feature.description || '').length > 200">
          <p>{{ isExpanded ? feature.description : `${feature.description.slice(0,
            200)}...`
            }}</p>
          <button
            v-if="feature.description"
            class="
          text-amber-500
          hover:underline"
            @click="toggleReadMore()"
          >{{ isExpanded ? "Read Less" : "Read More" }}</button>
        </div>
        <div v-else>
          <p>{{ feature.description || '' }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
