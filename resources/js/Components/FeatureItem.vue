<script setup lang="ts">
import { Feature } from '@/types';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import FeatureDropdown from './FeatureDropdown.vue';
import { can } from '@/helpers';

const props = defineProps<{
  feature: Feature;
}>();

const user = usePage().props.auth.user
const isExpanded = ref(false);
const toggleReadMore = () => {
  isExpanded.value = !isExpanded.value
}

</script>

<template>
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
        <div>
          <Link
            :href="route('features.show', feature)"
            class="text-xs"
          >
          {{ feature.comments_count }} comments
          </Link>
        </div>
      </div>
      <FeatureDropdown
        v-if="can(user, 'manage_features')"
        :feature="feature"
      >
      </FeatureDropdown>
    </div>
  </div>
</template>
