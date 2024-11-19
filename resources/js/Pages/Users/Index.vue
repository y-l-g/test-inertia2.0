<script setup lang="ts">
import { can } from "@/helpers";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { PaginatedData, User } from "@/types";
import { Head, Link, router, useForm, usePage } from "@inertiajs/vue3";
const props = defineProps<{
  users: PaginatedData<User>;
}>();
const deleteButton = useForm({})
const user = usePage().props.auth.user
</script>

<template>

  <Head title="Features" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Users
      </h2>
    </template>
    <Link
      v-if="can(user, 'manage_users')"
      :href="route('users.create')"
      class="mb-8 inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
    >
    Create new User
    </Link>
    <div class="w-full overflow-x-scroll">
      <table class=" w-full text-left table-auto min-w-max bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
        <thead class=" text-gray-900 dark:text-gray-100">
          <tr>
            <th
              class="p-4"
              scope="col"
            >User Id</th>
            <th
              class="p-4"
              scope="col"
            >User Name</th>
            <th
              class="p-4"
              scope="col"
            >User Email</th>
            <th
              class="p-4"
              scope="col"
            >User Roles</th>
            <th
              class="p-4"
              scope="col"
            >Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in users.data"
            :key="user.id"
            :user="user"
            class="m-6 p-6 text-gray-900 dark:text-gray-100"
          >
            <td class="p-4">{{ user.id }}</td>
            <td class="p-4">{{ user.name }}</td>
            <td class="p-4">{{ user.email }}</td>
            <td class="p-4">{{ user.roles.join(', ') }}</td>
            <td class="p-4">
              <button
                @click="router.get(route('users.edit', user.id))"
                class="px-4"
              >Edit
              </button>
              <button @click="deleteButton.delete(route('users.destroy', user.id))">Delete</button>
            </td>

          </tr>
        </tbody>

      </table>
    </div>

  </AuthenticatedLayout>
</template>
