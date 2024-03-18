<template>
  <svg
    class="fill-current"
    :class="[sizeClass, colorClass, hoverClass]"
    viewBox="0 0 24 24"
  >
    <path
      d="M22 18.055v2.458c0 1.925-4.655 3.487-10 3.487-5.344 0-10-1.562-10-3.487v-2.458c2.418 1.738 7.005 2.256 10 2.256 3.006 0 7.588-.523 10-2.256zm-10-3.409c-3.006 0-7.588-.523-10-2.256v2.434c0 1.926 4.656 3.487 10 3.487 5.345 0 10-1.562 10-3.487v-2.434c-2.418 1.738-7.005 2.256-10 2.256zm0-14.646c-5.344 0-10 1.562-10 3.488s4.656 3.487 10 3.487c5.345 0 10-1.562 10-3.487 0-1.926-4.655-3.488-10-3.488zm0 8.975c-3.006 0-7.588-.523-10-2.256v2.44c0 1.926 4.656 3.487 10 3.487 5.345 0 10-1.562 10-3.487v-2.44c-2.418 1.738-7.005 2.256-10 2.256z"
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
