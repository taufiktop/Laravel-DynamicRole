<template>
  <button
    class="flex justify-center items-center focus:outline-none py-2 px-4 rounded text-sm"
    @click="$emit('clicked')"
  >
    <slot />
  </button>
</template>

<script>
export default {};
</script>
