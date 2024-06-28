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
                            class="px-6 py-3 text-zinc-900 dark:text-white whitespace-nowrap"
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
import { watch } from "vue";

import Pagination from "./Pagination.vue";
import Search from "./Search.vue";

const props = defineProps({
    resources: Object,
});

// Function to update CSS custom properties
function updateCustomProperties(color, hex) {
    for (const [key, value] of Object.entries(hex)) {
        document.documentElement.style.setProperty(
            `--vilt-${color}-${key}`,
            value,
        );
    }
}

// Watch for changes in props.resources to update colors
watch(
    () => props.resources,
    (theme) => {
        if (theme && theme.color) {
            updateCustomProperties(
                theme.color.name,
                theme.color.hex,
            );
        }
    },
    { immediate: true, deep: true },
);
</script>

<style>
:root {
    /* purple colors */
    --vilt-primary-50: 250, 245, 255;
    --vilt-primary-100: 243, 232, 255;
    --vilt-primary-200: 233, 213, 255;
    --vilt-primary-300: 216, 180, 254;
    --vilt-primary-400: 192, 132, 252;
    --vilt-primary-500: 168, 85, 247;
    --vilt-primary-600: 147, 51, 234;
    --vilt-primary-700: 126, 34, 206;
    --vilt-primary-800: 107, 33, 168;
    --vilt-primary-900: 88, 28, 135;
    --vilt-primary-950: 59, 7, 100;

    /* vilt-info colors */
    --vilt-info-50: 239, 246, 255;
    --vilt-info-100: 219, 234, 254;
    --vilt-info-200: 191, 219, 254;
    --vilt-info-300: 147, 197, 253;
    --vilt-info-400: 96, 165, 250;
    --vilt-info-500: 59, 130, 246;
    --vilt-info-600: 37, 99, 235;
    --vilt-info-700: 29, 78, 216;
    --vilt-info-800: 30, 64, 175;
    --vilt-info-900: 30, 58, 138;
    --vilt-info-950: 23, 37, 84;

    /* vilt-success colors */
    --vilt-success-50: 240, 253, 244;
    --vilt-success-100: 220, 252, 231;
    --vilt-success-200: 187, 247, 208;
    --vilt-success-300: 134, 239, 172;
    --vilt-success-400: 74, 222, 128;
    --vilt-success-500: 34, 197, 94;
    --vilt-success-600: 22, 163, 74;
    --vilt-success-700: 21, 128, 61;
    --vilt-success-800: 22, 101, 52;
    --vilt-success-900: 20, 83, 45;
    --vilt-success-950: 5, 46, 22;

    /* vilt-warning colors */
    --vilt-warning-50: 254, 252, 232;
    --vilt-warning-100: 254, 249, 195;
    --vilt-warning-200: 254, 240, 138;
    --vilt-warning-300: 253, 224, 71;
    --vilt-warning-400: 250, 204, 21;
    --vilt-warning-500: 234, 179, 8;
    --vilt-warning-600: 202, 138, 4;
    --vilt-warning-700: 161, 98, 7;
    --vilt-warning-800: 133, 77, 14;
    --vilt-warning-900: 113, 63, 18;
    --vilt-warning-950: 66, 32, 6;

    /* vilt-danger colors */
    --vilt-danger-50: 254, 242, 242;
    --vilt-danger-100: 254, 226, 226;
    --vilt-danger-200: 254, 202, 202;
    --vilt-danger-300: 252, 165, 165;
    --vilt-danger-400: 248, 113, 113;
    --vilt-danger-500: 239, 68, 68;
    --vilt-danger-600: 220, 38, 38;
    --vilt-danger-700: 185, 28, 28;
    --vilt-danger-800: 153, 27, 27;
    --vilt-danger-900: 127, 29, 29;
    --vilt-danger-950: 69, 10, 10;

    /* vilt-custom colors (placeholder) */
    --vilt-custom-50: 204, 204, 204;
    --vilt-custom-100: 187, 187, 187;
    --vilt-custom-200: 170, 170, 170;
    --vilt-custom-300: 153, 153, 153;
    --vilt-custom-400: 136, 136, 136;
    --vilt-custom-500: 119, 119, 119;
    --vilt-custom-600: 102, 102, 102;
    --vilt-custom-700: 85, 85, 85;
    --vilt-custom-800: 68, 68, 68;
    --vilt-custom-900: 51, 51, 51;
    --vilt-custom-950: 34, 34, 34;
}
</style>
