<template>
  <div class="pl-5 pr-4 py-2">
    <ul class="flex flex-col space-y-1">
      <li v-if="label" class="flex uppercase text-gray-600 text-sm">
        <span class="py-2">{{ label }}</span>
      </li>
      <slot />
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    label: String,
  },
};
</script>
