<template>
  <div class="w-full bg-white rounded">
    <div
      class="bg-white border-t-4 border-teal-500 px-4 py-2 text-gray-600 font-medium text-lg rounded"
    >
      {{ header }}
    </div>
    <div class="px-4 py-2">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    header: String,
  },
};
</script>
