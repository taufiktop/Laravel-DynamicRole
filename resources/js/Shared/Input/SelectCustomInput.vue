<template>
  <ValidationProvider
    tag="div"
    :rules="rules"
    :name="name"
    :vid="vid"
    v-slot="{ errors }"
  >
    <div class="space-y-1">
      <label
        id="listbox-label"
        class="block text-sm leading-5 font-medium text-gray-700"
      >
        <slot name="SelectLabel"></slot>
      </label>

      <div class="relative" v-on-clickaway="closeDropdown">
        <span class="inline-block w-full rounded shadow-sm">
           <input
                style="display:none"
                v-model="selected"
            />
          <button
            type="button"
            @click="openDropdown"
            class="cursor-pointer relative w-full rounded border border-gray-300 bg-white pl-3 pr-10 py-2 text-left focus-within:form-input transition ease-in-out duration-150 sm:text-sm sm:leading-5 h-10"
          >
             <!-- font bold label -->
            <div class="flex items-center space-x-3" v-if="boldLabel">
              <span v-if="selected == ''" class="block truncate font-bold">
                {{ defaultOpt }}
              </span>
              <span v-else class="block truncate font-bold">
                {{ getOptionLabel(selected) }}
              </span>
            </div>

            <div class="flex items-center space-x-3" v-else>
              <span v-if="selected == ''" class="block truncate">
                {{ defaultOpt }}
              </span>
              <span v-else class="block truncate">
                {{ getOptionLabel(selected) }}
              </span>
            </div>
            
            <div
              v-show="selected && clearable"
              class="absolute inset-y-0 right-6 flex items-center p-2 cursor-pointer h-full"
              @click.stop="clearSelected"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                class="fill-current h-3 w-3 text-gray-400"
              >
                <path
                  d="M23 20.168l-8.185-8.187 8.185-8.174-2.832-2.807-8.182 8.179-8.176-8.179-2.81 2.81 8.186 8.196-8.186 8.184 2.81 2.81 8.203-8.192 8.18 8.192z"
                />
              </svg>
            </div>
            <span
              class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
            >
              <svg
                class="fill-current flex-shrink-0 w-2 h-2 text-gray-500"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                v-if="downIcon"
              >
                <path
                  d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"
                />
              </svg>
              <svg
                class="h-5 w-5 text-gray-400"
                viewBox="0 0 20 20"
                fill="none"
                stroke="currentColor"
                v-else
              >
                <path
                  d="M7 7l3-3 3 3m0 6l-3 3-3-3"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </span>
          </button>
        </span>
        <span class="form-error">{{ errors[0] }}</span>

        <!-- Select popover, show/hide based on select state. -->
        <transition
          leave-active-class="transition ease-in duration-150"
          leave-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <!-- <div
            v-show="isOpen"
            class="absolute mt-2 w-full rounded bg-white shadow-md z-50 border"
            :class="{ 'top-auto bottom-full mb-2': isAbove }"
          > -->
          <div
            v-show="isOpen"
            class="absolute mt-2 min-w-full rounded bg-white shadow-md z-50 border"
            :class="{ 'top-auto bottom-full mb-2': isAbove }"
          >
            <ul
              tabindex="-1"
              role="listbox"
              aria-labelledby="listbox-label"
              aria-activedescendant="listbox-item-3"
              class="max-h-56 rounded py-1 text-base leading-6 shadow-sm overflow-auto focus:outline-none sm:text-sm sm:leading-5 dre"
            >
            
              <!-- <li
                tabindex="0"
                @click="clearSelected(d)"
                class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9  cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:text-gray-900 focus:bg-gray-100"
              >
                <div class="flex items-center space-x-3">
                  <span class="block truncate text-sm">
                    {{ defaultOpt }}
                  </span>
                </div>
              </li> -->

              <!--
              Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.
            -->
            <template>
              <!-- <li
                tabindex="0"
                @click="select(d)"
                id="listbox-item-0"
                role="option"
                v-for="(d, index) in options"
                v-bind:key="index"
                class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9  cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:text-gray-900 focus:bg-gray-100"
                v-bind:class="{
                  'bg-gray-100 opacity-50': isSelected(d) && tagOption,
                }"
              > -->
              <li
                tabindex="0"
                @click="select(d)"
                id="listbox-item-0"
                role="option"
                v-for="(d, index) in options"
                v-bind:key="index"
                class="flex text-gray-900 cursor-default select-none relative py-2 pl-3 pr-6  cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:text-gray-900 focus:bg-gray-100"
                v-bind:class="{
                  'bg-gray-100 opacity-50': isSelected(d) && tagOption,
                }"
              >
                <div class="flex items-center space-x-3">
                  <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                  <span class="block truncate text-sm">
                    {{ getOptionLabel(d) }}
                  </span>
                </div>

                <!--
                Checkmark, only display for selected option.
              -->
                <!-- <span
                  v-show="isSelected(d) && tagOption"
                  class="absolute inset-y-0 right-0 flex items-center pr-4"
                > -->
                <span
                  v-show="isSelected(d) && tagOption"
                  class=" absolute inset-y-0 right-0 flex items-center"
                >
                  <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path
                      fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </span>
              </li>
              </template>
            </ul>
          </div>
        </transition>
      </div>
    </div>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from "vee-validate";
import { mixin as clickaway } from "vue-clickaway";

export default {
  name: "SelectCustomInput",
  mixins: [clickaway],
  props: {
    rules: {
      type: [String, Object],
      default: "",
    },
    name: {
      type: String,
      default: "",
    },
    vid: {
      type: String,
      default: undefined,
    },
    injectClass: {
      default: "",
      type: String,
    },
    defaultOpt: {
      type: String,
      default: "Please select one",
    },
    options: {
      type: Array,
      required: true,
    },
    customLabel: {
      type: Function,
      default(option, label) {
        if (Array.isArray(option) && option.length === 0) return "";
        return label ? option[label] : option;
      },
    },
    value: {
      type: [String, Object],
      default: "",
    },
    label: {
      type: String,
    },
    clearable: {
      type: Boolean,
      default: false,
    },
    downIcon: {
      type: Boolean,
      default: false,
    },
    boldLabel: {
      type: Boolean,
      default: false,
    },
    tagOption: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      isOpen: false,
      selected: "",
      isAbove: false,
    };
  },
  methods: {
    isSelected(option) {
      return this.selected === option;
    },
    closeDropdown() {
      this.isOpen = false;
    },
    openDropdown() {
      this.adjustPosition();
      this.isOpen = !this.isOpen;
    },
    select(option) {
      if(this.tagOption == true){
        this.selected = this.selected == option ? "" : option;
      }
      else{
        this.selected = option;
      }
      this.isOpen = false;

      this.$emit("input", this.selected);
    },
    clearSelected() {
      this.selected = "";
      this.isOpen = false;
      this.$emit("input", this.selected);
    },
    adjustPosition() {
      if (typeof window === "undefined") return;

      const spaceAbove = this.$el.getBoundingClientRect().top;
      const spaceBelow =
        window.innerHeight - this.$el.getBoundingClientRect().bottom;

      if (spaceBelow > spaceAbove) {
        this.isAbove = false;
      } else {
        this.isAbove = true;
      }
    },
    getOptionLabel(option) {
      if (Array.isArray(option) && option.length === 0) return "";
      let label = this.customLabel(option, this.label);
      if (Array.isArray(label) && label.length === 0) return "";
      return label;
    },
  },
  components: {
    ValidationProvider,
  },
  created(){
    this.selected = this.value || ''
  },
  watch: {
    value(newval) {
      // if (!!newval === false) return ''
      this.selected = newval;
    },
  },
};
</script>
