<template>
  <svg
    class="fill-current"
    :class="[sizeClass, colorClass, hoverClass]"
    viewBox="0 0 24 24"
  >
    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
  </svg>
</template>

<script>
export default {
  props: {
    size: {
      required: false,
      type: String,
    },
    color: {
      required: false,
      type: String,
    },
    hover: {
      required: false,
      type: String,
    },
  },
  computed: {
    sizeClass() {
      return this.size || "h-6 w-6";
    },
    colorClass() {
      return this.color || "text-gray-500";
    },
    hoverClass() {
      return this.hover || "hover:text-gray-600";
    },
  },
};
</script>
