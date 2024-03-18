<template>
  <transition
    enter-active-class="transition ease-in-out duration-500"
    enter-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition ease-in-out duration-500"
    leave-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <!-- <div class="fixed inset-0 overflow-hidden z-50" v-show="show"> -->
    <div class="absolute inset-0 overflow-hidden z-50" v-show="show">
      <div class="absolute inset-0 overflow-hidden">
        <transition
          enter-active-class="transition ease-in-out duration-500"
          enter-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="transition ease-in-out duration-500"
          leave-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div
            class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            v-show="show"
          ></div>
        </transition>
        <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
          <transition
            enter-active-class="transition transform ease-in-out duration-500"
            enter-class="translate-x-full"
            enter-to-class="translate-x-0"
            leave-active-class="transition transform ease-in-out duration-500"
            leave-class="translate-x-0"
            leave-to-class="translate-x-full"
          >
            <div class="relative w-screen max-w-sm" v-show="show">
              <transition
                enter-active-class="transition ease-in-out duration-500"
                enter-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in-out duration-500"
                leave-class="opacity-100"
                leave-to-class="opacity-0"
              >
                <div
                  class="h-full flex flex-col space-y-6 bg-white shadow-xl overflow-y-scroll"
                  v-show="show"
                >
                  <header
                    class="px-4 py-6 sm:px-6 flex justify-between bg-gray-50"
                  >
                    <h2 class="text-lg leading-7 font-semibold text-gray-700">
                      <slot name="title" />
                    </h2>
                    <button
                      aria-label="Close panel"
                      class="text-gray-500 hover:text-gray-600 transition ease-in-out duration-150 focus:outline-none"
                      @click.stop.prevent="$emit('close')"
                    >
                      <!-- Heroicon name: x -->
                      <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"
                        />
                      </svg>
                    </button>
                  </header>
                  <div class="relative flex-1 px-4 sm:px-6 overflow-auto dre">
                    <!-- Replace with your content -->
                    <div class="absolute inset-0 px-4 sm:px-6">
                      <slot name="content" />
                    </div>
                    <!-- /End replace -->
                  </div>
                  <footer class="px-4 py-5 sm:px-6 bg-gray-50 z-50">
                    <slot name="footer" />
                  </footer>
                </div>
              </transition>
            </div>
          </transition>
        </section>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    show: Boolean,
  },
};
</script>
