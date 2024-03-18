<template>
  <li>
    <inertia-link
      :href="to"
      class="flex space-x-2 p-2 hover:bg-graylight w-full text-sm font-semibold tracking-wider text-gray-600 hover:text-gray-800 rounded"
      :class="isUrl ? 'bg-graylight text-gray-800' : ''"
      ><slot /> <span class="leading-tight">{{ label }}</span>
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
