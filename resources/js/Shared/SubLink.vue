<template>
  <li>
    <inertia-link
      class="flex py-1 text-sm font-medium tracking-wide hover:text-gray-800"
      :href="to"
      :class="isUrl ? 'text-gray-800' : 'text-gray-600'"
    >
      {{ label }}
    </inertia-link>
  </li>
</template>

<script>
export default {
  props: {
    to: String,
    label: String,
  },
  computed: {
    isUrl() {
      return this.to == location.href ? true : false;
    },
  },
};
</script>
