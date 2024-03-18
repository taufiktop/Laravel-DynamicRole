<template>
  <svg
    class="fill-current"
    :class="[sizeClass, colorClass, hoverClass]"
    viewBox="0 0 24 24"
  >
    <path
      d="M18 14.45v6.55h-16v-12h6.743l1.978-2h-10.721v16h20v-10.573l-2 2.023zm1.473-10.615l1.707 1.707-9.281 9.378-2.23.472.512-2.169 9.292-9.388zm-.008-2.835l-11.104 11.216-1.361 5.784 5.898-1.248 11.103-11.218-4.536-4.534z"
    />
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
