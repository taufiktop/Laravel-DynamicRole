<template>
  <li>
    <a
      class="relative flex items-end space-x-2 p-2 hover:bg-graylight w-full text-sm font-semibold tracking-wider hover:text-gray-800 text-gray-600 rounded transition duration-100 eas-in-out hover:text-gray-700 "
      href="javascript:void(0)"
      @click="show = !show"
      :class="{ 'bg-graylight text-gray-800': show }"
    >
      <!-- Leading Icon -->
      <slot name="svg"></slot>
      <span class="leading-tight">{{ label }}</span>
      <!-- Arrow Bottom Icon -->
      <transition
        enter-class="opacity-0 transform translate-y-2"
        enter-active-class="transition ease-out duration-150"
        enter-to-class="opacity-100 transform translate-y-0"
        leave-class="opacity-100 transform translate-y-0"
        leave-active-class="transition ease-in duration-150"
        leave-to-class="opacity-0 transform translate-y-2"
      >
        <div class="absolute inset-y-0 right-0 p-3" v-show="!show">
          <svg
            class="fill-current flex-shrink-0 w-2 h-2"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
          >
            <path
              d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"
            />
          </svg>
        </div>
      </transition>
      <!-- Arrow Top Icon -->
      <transition
        enter-class="opacity-0 transform -translate-y-2"
        enter-active-class="transition ease-out duration-150"
        enter-to-class="opacity-100 transform translate-y-0"
        leave-class="opacity-100 transform translate-y-0"
        leave-active-class="transition ease-in duration-150"
        leave-to-class="opacity-0 transform -translate-y-2"
      >
        <div class="absolute inset-y-0 right-0 p-3" v-show="show">
          <svg
            class="fill-current flex-shrink-0 w-2 h-2 text-gray-700"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
          >
            <path
              d="M0 16.67l2.829 2.83 9.175-9.339 9.167 9.339 2.829-2.83-11.996-12.17z"
            />
          </svg>
        </div>
      </transition>
    </a>
    <transition
      enter-active-class="transition ease-out duration-300"
      enter-class="opacity-0 transform translate-x-3"
      enter-to-class="opacity-100 transform translate-x-0"
    >
      <ul class="pl-8 bg-lighter" v-show="show">
        <slot />
      </ul>
    </transition>
  </li>
</template>

<script>
export default {
  props: {
    label: String,
    tag: String,
  },
  data() {
    return {
      show: location.href.includes(this.tag) ? true : false,
    };
  },
};
</script>
