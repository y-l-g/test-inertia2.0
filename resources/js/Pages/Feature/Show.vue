<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Textarea from "@/Components/Textarea.vue";
import { can } from "@/helpers";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Feature, PaginatedData } from "@/types";
import { Head, router, useForm, usePage } from "@inertiajs/vue3";
const props = defineProps<{
  feature: Feature;
}>();

const form = useForm({
  comment: "",
});
const deleteForm = useForm({});

const user = usePage().props.auth.user
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
          <form
            v-if="can(user, 'manage_comments')"
            @submit.prevent="form.post(route('comments.store', feature),
              {
                preserveScroll: true,
                onSuccess: () => form.reset()
              })"
            class="mt-6 space-y-6 w-full"
          >
            <div>
              <InputLabel
                for="comment"
                value="Comment"
              />

              <Textarea
                id="comment"
                rows="3"
                class="mt-1 block w-full"
                v-model="form.comment"
                autocomplete="comment"
                placeholder="Your Comment"
              />

              <InputError
                class="mt-2"
                :message="form.errors.comment"
              />
            </div>
            <PrimaryButton :disabled="form.processing">Submit</PrimaryButton>
          </form>
          <div
            v-for="comment in feature.comments"
            class="sm:mr-20 mr-0 my-4 bg-white shadow-sm rounded-lg dark:bg-gray-900"
          >
            <div class="w-full p-5 text-gray-900 dark:text-gray-100 flex gap-6 items-center">
              <div class="flex gap-6 flex-1">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="2"
                  stroke="currentColor"
                  class="size-10  rounded-full p-2 dark:bg-gray-600"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                  />
                </svg>
                <div
                  flex
                  flex-col
                >
                  <div>
                    <span class="font-bold mr-4">{{ comment.user.name }}</span>
                    <span class="text-xs dark:text-gray-400">{{ comment.created_at }}</span>
                  </div>
                  <div class="mt-2 italic">{{ comment.comment }}</div>


                </div>
              </div>
              <button
                v-if="user.id === comment.user.id"
                :disabled="deleteForm.processing"
                @click="deleteForm.delete(route('comments.destroy', comment.id), {
                  preserveScroll: true,
                  preserveState: true
                })"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="size-6 "
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
