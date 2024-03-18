<template>
  <div
    id="mymain"
    class="w-full transition-all duration-300 ease-in-out text-gray-800 header open"
  >
    <div class="flex flex-col min-h-screen pt-16">
      <div class="flex flex-col flex-1 p-4">
        <slot name="content" />
      </div>
      <Footer />
    </div>
  </div>
</template>

<script>
import Footer from "@/Shared/Footer";
export default {
  components: {
    Footer,
  },
};
</script>
