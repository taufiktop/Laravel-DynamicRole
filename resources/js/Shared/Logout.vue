<template>
  <div
    class="fixed bottom-0 flex items-center w-full md:w-64 bg-white px-5 h-12"
  >
    <inertia-link
      :href="to"
      :data="{_token: $page.props.csrf_token}"
      method="post"
      as="button"
      class="flex space-x-2 p-2 hover:bg-graylight w-full text-sm font-semibold tracking-wider text-gray-600 hover:text-gray-800 rounded"
    >
      <svg
        class="fill-current flex-shrink-0 w-4 h-4 text-gray-700"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
      >
        <path
          d="M16 9v-4l8 7-8 7v-4h-8v-6h8zm-2 10v-.083c-1.178.685-2.542 1.083-4 1.083-4.411 0-8-3.589-8-8s3.589-8 8-8c1.458 0 2.822.398 4 1.083v-2.245c-1.226-.536-2.577-.838-4-.838-5.522 0-10 4.477-10 10s4.478 10 10 10c1.423 0 2.774-.302 4-.838v-2.162z"
        />
      </svg>
      <span class="leading-tight">{{ label }}</span>
    </inertia-link>
  </div>
</template>
<script>
export default {
  props: {
    to: String,
    label: String,
  },
};
</script>
