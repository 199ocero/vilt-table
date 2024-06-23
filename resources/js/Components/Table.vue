<template>
    <div
        class="bg-white shadow-sm rounded-xl ring-1 ring-zinc-950/5 dark:divide-white/10 dark:bg-zinc-900 dark:ring-white/10"
    >
        <div
            v-if="resources.heading || resources.description"
            class="p-5 text-lg font-semibold text-left bg-white rounded-t-xl text-zinc-900 dark:text-white dark:bg-zinc-900"
        >
            {{ resources.heading }}
            <p
                class="mt-1 text-sm font-normal text-zinc-500 dark:text-zinc-400"
            >
                {{ resources.description }}
            </p>
        </div>
        <div class="w-full p-5 border-t border-zinc-200">
            <Search :resources="resources" class="ml-auto" />
        </div>
        <div
            class="overflow-x-auto"
            :class="{
                'rounded-xl': !resources.heading && !resources.description,
            }"
        >
            <table
                class="w-full text-sm text-left text-zinc-500 dark:text-zinc-400"
            >
                <thead
                    class="dark:bg-zinc-800 bg-zinc-100 dark:border-zinc-700/60"
                    :class="{
                        'border-b':
                            !resources.heading && !resources.description,
                        'border-y': resources.heading || resources.description,
                    }"
                >
                    <tr>
                        <th
                            v-for="(value, key) in resources.columns"
                            :key="key"
                            scope="col"
                            class="px-6 py-3 text-zinc-900 dark:text-white"
                        >
                            {{ value }}
                        </th>
                    </tr>
                </thead>
                <tbody
                    v-if="resources.table.data.length > 0"
                    class="divide-y divide-zinc-200 whitespace-nowrap dark:divide-white/5"
                >
                    <tr
                        v-for="resource in resources.table.data"
                        :key="resource.id"
                        class="bg-white dark:bg-zinc-900"
                    >
                        <td
                            v-for="(value, key) in resources.columns"
                            :key="key"
                            v-text="resource[key]"
                            class="px-6 py-4 text-zinc-900 dark:text-white"
                        ></td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="100%">
                            <div
                                class="flex flex-col items-center justify-center w-full gap-2 py-10"
                            >
                                <div
                                    class="w-10 h-10 p-2 rounded-full bg-zinc-100 dark:bg-zinc-800"
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
                                            d="M6 18 18 6M6 6l12 12"
                                        />
                                    </svg>
                                </div>
                                <p
                                    v-text="resources.emptyStateHeading"
                                    class="font-bold text-zinc-900 dark:text-white"
                                ></p>
                                <p
                                    v-if="resources.emptyStateDescription"
                                    v-text="resources.emptyStateDescription"
                                    class="text-sm text-zinc-600 dark:text-zinc-500"
                                ></p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-5 border-t dark:border-zinc-800 border-zinc-200">
            <Pagination :resources="resources" />
        </div>
    </div>
</template>

<script setup>
import Pagination from './Pagination.vue';
import Search from './Search.vue';

const props = defineProps({
    resources: Object,
});
</script>
