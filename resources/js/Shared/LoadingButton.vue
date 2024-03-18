<template>
  <button
    :disabled="loading"
    class="flex justify-center items-center focus:outline-none"
    :class="{ 'opacity-75': loading }"
  >
    <div v-if="loading" class="btn-spinner" />
    <slot v-if="!loading" />
  </button>
</template>

<script>
export default {
  props: {
    loading: Boolean,
  },
};
</script>
