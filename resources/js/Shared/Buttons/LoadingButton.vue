<template>
  <button
    :disabled="loading"
    class="flex justify-center items-center focus:outline-none py-2 px-4 rounded text-base sm:text-sm"
    :class="{ 'opacity-75': loading }"
    @click="$emit('clicked')"
  >
    <div v-if="loading" class="btn-spinner mr-2" />
    <slot />
  </button>
</template>

<script>
export default {
  props: {
    loading: Boolean,
  },
};
</script>
