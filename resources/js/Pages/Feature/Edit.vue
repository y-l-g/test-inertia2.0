<script setup lang="ts">
import FeatureItem from "@/Components/FeatureItem.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Textarea from "@/Components/Textarea.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Feature, PaginatedData } from "@/types";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";

const props = defineProps<{
  feature: Feature;
}>();

const form = useForm({
  name: props.feature.name,
  description: props.feature.description,
});
</script>

<template>

  <Head :title="'Edit Feature' + feature.name" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Edit Feature "{{ feature.name }}"
      </h2>
    </template>

    <div class="mb-4 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
      <div class="p-6 text-gray-900 dark:text-gray-100 flex gap-8">

        <form
          @submit.prevent="form.patch(route('features.update', feature))"
          class="mt-6 space-y-6 w-full"
        >
          <div>
            <InputLabel
              for="name"
              value="Name"
            />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
            />

            <InputError
              class="mt-2"
              :message="form.errors.name"
            />
          </div>

          <div>
            <InputLabel
              for="description"
              value="Description"
            />

            <Textarea
              id="description"
              class="mt-1 block w-full"
              v-model="form.description"
              autocomplete="description"
            />

            <InputError
              class="mt-2"
              :message="form.errors.description"
            />
          </div>
          <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            <Transition
              enter-active-class="transition ease-in-out"
              enter-from-class="opacity-0"
              leave-active-class="transition ease-in-out"
              leave-to-class="opacity-0"
            >
              <p
                v-if="form.recentlySuccessful"
                class="text-sm text-gray-600 dark:text-gray-400"
              >
                Saved.
              </p>
            </Transition>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
