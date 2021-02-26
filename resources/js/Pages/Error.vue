<template>
    <breeze-authenticated-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-2xl font-extrabold tracking-wide text-pink-700">{{ title }}</h1>
                <p class="tracking-wider">{{ description }}</p>
            </div>
        </div>

        <div>

        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
export default {
    components: {
        BreezeAuthenticatedLayout,
    },

    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: "503: Service Unavailable",
                500: "500: Server Error",
                404: "404: Page Not Found",
                403: "403: Forbidden",
            }[this.status];
        },
        description() {
            return {
                503: "Sorry, we are doing some maintenance. Please check back soon.",
                500: "Whoops, something went wrong on our servers.",
                404: "Sorry, the page you are looking for could not be found.",
                403: "Sorry, you are forbidden from accessing this page.",
            }[this.status];
        },
    },
};
</script>
