<template>
    <div class="mt-1 relative rounded-md shadow-sm w-auto">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500 sm:text-sm">
                <i
                    class="fa fa-search"
                    aria-hidden="true"
                ></i>
            </span>
        </div>
        <input
            type="search"
            name="search"
            id="search"
            autocomplete="off"
            class="focus:ring-indigo-100 focus:border-indigo-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-lg"
            placeholder=""
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
        />
    </div>
</template>

<script>
export default {
    props: ["modelValue"],

    emits: ["update:modelValue"],

    methods: {
        focus() {
            this.$refs.input.focus();
        },
    },
};
</script>

