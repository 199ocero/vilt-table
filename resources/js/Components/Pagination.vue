<template>
    <div
        class="flex flex-col items-center justify-center w-full space-y-5 lg:justify-between lg:flex-row lg:space-y-0"
    >
        <!-- Help text -->
        <span class="text-sm text-zinc-700 dark:text-zinc-400">
            Showing
            <span
                class="font-semibold text-zinc-900 dark:text-white"
                v-text="resources.table.from ?? 0"
            ></span>
            to
            <span
                class="font-semibold text-zinc-900 dark:text-white"
                v-text="resources.table.to"
            ></span>
            of
            <span
                class="font-semibold text-zinc-900 dark:text-white"
                v-text="resources.table.total"
            ></span>
            Entries
        </span>

        <button
            class="flex flex-row items-center pr-2 border rounded-lg cursor-default dark:bg-zinc-800 border-zinc-300 dark:border-zinc-700 focus:outline-none focus:ring-2"
            :class="{
                'focus:dark:ring-vilt-primary-500 focus:ring-vilt-primary-600':
                    themeColor === 'primary',
                'focus:dark:ring-vilt-success-500 focus:ring-vilt-success-600':
                    themeColor === 'success',
                'focus:dark:ring-vilt-warning-500 focus:ring-vilt-warning-600':
                    themeColor === 'warning',
                'focus:dark:ring-vilt-danger-500 focus:ring-vilt-danger-600':
                    themeColor === 'danger',
                'focus:dark:ring-vilt-info-500 focus:ring-vilt-info-600':
                    themeColor === 'info',
                'focus:dark:ring-vilt-custom-500 focus:ring-vilt-custom-600':
                    themeColor === 'custom',
            }"
        >
            <div
                class="flex items-center h-10 p-2 text-sm border-r text-zinc-500 dark:text-zinc-500 border-zinc-300 dark:border-zinc-700"
            >
                <span>Per page</span>
            </div>
            <select
                v-model="perPage"
                class="h-10 p-2 text-sm outline-none dark:bg-zinc-800 dark:text-white focus:ring-0"
            >
                <option
                    v-for="option in perPageOptions"
                    :key="option"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
        </button>

        <div aria-label="Page Pagination" class="w-full lg:w-auto">
            <ul
                class="flex flex-wrap items-center justify-center w-full h-auto -space-x-px text-base lg:justify-end"
            >
                <li v-if="resources.table.prev_page_url">
                    <Link
                        :href="resources.table.prev_page_url"
                        preserve-scroll
                        class="flex items-center justify-center h-10 px-4 leading-tight bg-white border text-zinc-500 border-zinc-300 ms-0 border-e-0 rounded-s-lg hover:bg-zinc-100 hover:text-zinc-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:hover:text-white"
                    >
                        <span class="sr-only">Previous</span>
                        <svg
                            class="w-3 h-3 rtl:rotate-180"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 1 1 5l4 4"
                            />
                        </svg>
                    </Link>
                </li>
                <template v-for="link in filteredLinks" :key="link.url">
                    <li>
                        <Link
                            :href="link.url ? link.url : 'javascript:void(0)'"
                            preserve-scroll
                            class="flex items-center justify-center h-10 px-4 leading-tight border"
                            :class="{
                                'text-vilt-primary-600 dark:text-vilt-primary-400':
                                    link.active &&
                                    themeColor === 'primary',
                                'text-vilt-success-600 dark:text-vilt-success-400':
                                    link.active &&
                                    themeColor === 'success',
                                'text-vilt-warning-600 dark:text-vilt-warning-400':
                                    link.active &&
                                    themeColor === 'warning',
                                'text-vilt-danger-600 dark:text-vilt-danger-400':
                                    link.active && themeColor === 'danger',
                                'text-vilt-info-600 dark:text-vilt-info-400':
                                    link.active && themeColor === 'info',
                                'text-vilt-custom-600 dark:text-vilt-custom-400':
                                    link.active && themeColor === 'custom',
                                'bg-zinc-100 dark:bg-zinc-800/70 dark:border-zinc-700 border-zinc-300':
                                    link.active,
                                'dark:bg-zinc-800 dark:text-zinc-400 bg-white text-zinc-900 dark:border-zinc-700 border-zinc-300 hover:bg-zinc-100 hover:text-zinc-700 dark:hover:bg-zinc-700 dark:hover:text-white':
                                    !link.active,
                                'rounded-s-lg':
                                    resources.table.current_page === 1 &&
                                    link.active,
                                'rounded-e-lg':
                                    resources.table.last_page ===
                                        resources.table.current_page &&
                                    link.active,
                                'pointer-events-none': !link.url,
                            }"
                            >{{ link.label }}</Link
                        >
                    </li>
                </template>
                <li v-if="resources.table.next_page_url">
                    <Link
                        :href="resources.table.next_page_url"
                        preserve-scroll
                        class="flex items-center justify-center h-10 px-4 leading-tight bg-white border text-zinc-500 border-zinc-300 rounded-e-lg hover:bg-zinc-100 hover:text-zinc-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:hover:text-white"
                    >
                        <span class="sr-only">Next</span>
                        <svg
                            class="w-3 h-3 rtl:rotate-180"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 9 4-4-4-4"
                            />
                        </svg>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";

const props = defineProps({
    resources: Object,
});

let perPageOptions = ref(props.resources.pagination);
let perPage = ref(props.resources.filters.perPage);

watch(perPage, (value) => {
    const currentPath = window.location.pathname;
    router.get(
        currentPath,
        {
            perPage: value,
            page: props.resources.filters.page,
            search: props.resources.filters.search,
        },
        { preserveState: true, preserveScroll: true },
    );
});

const filteredLinks = computed(() => {
    return props.resources.table.links.filter((link) => {
        return (
            link.label !== "&laquo; Previous" && link.label !== "Next &raquo;"
        );
    });
});

const themeColor = computed(() => {
    return props.resources.color.name;
});
</script>
