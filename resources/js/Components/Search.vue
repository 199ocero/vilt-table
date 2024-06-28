<template>
    <div class="w-full max-w-sm">
        <div class="relative">
            <div
                class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3"
            >
                <svg
                    class="w-4 h-4 text-zinc-400 dark:text-zinc-500"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 20 20"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                    />
                </svg>
            </div>
            <input
                v-model="search"
                type="text"
                class="w-full px-4 py-3 text-sm border rounded-lg place-holder-zinc-400 dark:placeholder-zinc-500 text-zinc-900 dark:text-white ps-10 dark:bg-zinc-800 border-zinc-300 dark:border-zinc-700 focus:outline-none focus:ring-2"
                :class="{
                    'focus:dark:ring-vilt-primary-400 focus:ring-vilt-primary-600': themeColor === 'primary',
                    'focus:dark:ring-vilt-success-400 focus:ring-vilt-success-600': themeColor === 'success',
                    'focus:dark:ring-vilt-info-400 focus:ring-vilt-info-600': themeColor === 'info',
                    'focus:dark:ring-vilt-warning-400 focus:ring-vilt-warning-600': themeColor === 'warning',
                    'focus:dark:ring-vilt-danger-400 focus:ring-vilt-danger-600': themeColor === 'danger',
                    'focus:dark:ring-vilt-custom-400 focus:ring-vilt-custom-600 focus:border-none': themeColor === 'custom',
                }"
                placeholder="Search"
                required
            />
        </div>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";
import debounce from "lodash/debounce";

const props = defineProps({
    resources: Object,
});

let search = ref(props.resources.filters.search);

watch(
    search,
    debounce(function (value) {
        const currentPath = window.location.pathname;
        router.get(
            currentPath,
            {
                perPage: props.resources.filters.perPage,
                page: props.resources.filters.page,
                search: value,
            },
            { preserveState: true, preserveScroll: true },
        );
    }, 300),
);

const themeColor = computed(() => {
    return props.resources.color.name;
});
</script>
