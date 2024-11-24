<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import Dropdown from './Dropdown.vue';
import DropdownLink from './DropdownLink.vue';
import { Feature } from '@/types';

defineProps<{
  feature: Feature;
}>();

const deleteFeatureForm = useForm({});
</script>

<template>
  <Dropdown
    align="right"
    width="48"
  >
    <template #trigger>
      <span class="inline-flex rounded-md">
        <button
          type="button"
          class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z"
            />
          </svg>

        </button>
      </span>
    </template>

    <template #content>
      <DropdownLink :href="route('features.edit', feature.id)">
        Edit Feature
      </DropdownLink>
      <div
        class="cursor-pointer block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none dark:text-gray-300 dark:hover:bg-gray-800 dark:focus:bg-gray-800"
        @click="deleteFeatureForm.delete(route('features.destroy', feature.id), {
        })"
      >
        Delete Feature
      </div>
    </template>
  </Dropdown>
</template>
