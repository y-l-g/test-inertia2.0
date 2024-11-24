<script setup lang="ts">
import { Feature } from '@/types';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import FeatureDropdown from './FeatureDropdown.vue';
import { can } from '@/helpers';

const props = defineProps<{
  feature: Feature,
}>();

const upVoteForm = useForm({})

const user = usePage().props.auth.user
const isExpanded = ref(false);
const toggleReadMore = () => {
  isExpanded.value = !isExpanded.value
}
// const upVote = () => {
//   if (featureRef.value.user_vote == 1) {
//     return
//   }
//   else if (featureRef.value.user_vote == 0) {
//     featureRef.value.user_vote = null
//     featureRef.value.upvote_count++
//   } else {
//     featureRef.value.user_vote = 1
//     featureRef.value.upvote_count++
//   }
// }

const upVote = () => {
  if (props.feature.user_vote == 1) {
    return
  }
  else if (props.feature.user_vote == 0) {
    props.feature.user_vote = null
    props.feature.upvote_count++
  } else {
    props.feature.user_vote = 1
    props.feature.upvote_count++
  }
}

const downVote = () => {
  if (props.feature.user_vote == 0) {
    return
  }
  else if (props.feature.user_vote == 1) {
    props.feature.user_vote = null
    props.feature.upvote_count--
  } else {
    props.feature.user_vote = 0
    props.feature.upvote_count--
  }
}

</script>

<template>
  <div class="mb-4 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
    <div class="p-6 text-gray-900 dark:text-gray-100 flex gap-8">
      <div class="flex flex-col items-center">
        <button
          :disabled="upVoteForm.processing"
          @click="upVoteForm.post(route('features.upvote', feature.id), { preserveState: true, preserveScroll: true, only: [''], async: true, onSuccess: upVote })"
          :class="(feature.user_vote == 1 ? 'text-amber-600' : '')"
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
          :class="'text-2xl font-semibold' + ((feature.user_vote == 1 || feature.user_vote == 0) && ' text-amber-600')"
        >
          {{ feature.upvote_count }}
        </span>
        <button
          @click="router.post(route('features.downvote', feature.id), {}, { preserveState: true, preserveScroll: true, only: [''], onSuccess: downVote })"
          :class="feature.user_vote == 0 ? 'text-amber-600' : ''"
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
