<template>
  <svg
    class="fill-current"
    :class="[sizeClass, colorClass, hoverClass]"
    viewBox="0 0 24 24"
  >
    <path
      d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"
    ></path>
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
      return this.size || "h-6 w-4";
    },
    colorClass() {
      return this.color;
    },
    hoverClass() {
      return this.hover;
    },
  },
};
</script>

<style scoped></style>
