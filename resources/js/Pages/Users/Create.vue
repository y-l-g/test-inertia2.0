<script setup lang="ts">
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Textarea from "@/Components/Textarea.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
  roles: Array
})

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  roles: [],
});
</script>

<template>

  <Head title="Create new Feature" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Create new User
      </h2>
    </template>

    <div class="mb-4 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
      <div class="p-6 text-gray-900 dark:text-gray-100 flex gap-8">

        <form
          @submit.prevent="form.post(route('users.store'))"
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
              for="email"
              value="Email"
            />

            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              required
              autofocus
              autocomplete="email"
            />

            <InputError
              class="mt-2"
              :message="form.errors.email"
            />
          </div>

          <div>
            <InputLabel
              for="password"
              value="password"
            />

            <TextInput
              id="password"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password"
              required
              autofocus
              autocomplete="password"
            />

            <InputError
              class="mt-2"
              :message="form.errors.password"
            />
          </div>

          <div>
            <InputLabel
              for="password_confirmation"
              value="Password Confirmation"
            />

            <TextInput
              id="password_confirmation"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password_confirmation"
              required
              autofocus
              autocomplete="password_confirmation"
            />

            <InputError
              class="mt-2"
              :message="form.errors.password_confirmation"
            />
          </div>

          <div>
            <InputLabel
              for="roles"
              value="Roles"
            />
            <div
              v-for="(value, key) in roles"
              :key="key"
              class="flex items-center mt-2"
            >
              <input
                type="checkbox"
                :id="'role-' + value"
                :value="value"
                v-model="form.roles"
              />
              <label
                :for="'role-' + value"
                class=" ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
              >{{ key
                }}</label>
            </div>
            <InputError
              class="mt-2"
              :message="form.errors.roles"
            />
          </div>
          <PrimaryButton :disabled="form.processing">Create</PrimaryButton>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
