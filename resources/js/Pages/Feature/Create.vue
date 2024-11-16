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

const form = useForm({
  name: "",
  description: "",
});
</script>

<template>

  <Head title="Create new Feature" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Create new Feature
      </h2>
    </template>

    <div class="mb-4 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
      <div class="p-6 text-gray-900 dark:text-gray-100 flex gap-8">

        <form
          @submit.prevent="form.post(route('features.store'))"
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
          <PrimaryButton :disabled="form.processing">Create</PrimaryButton>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
