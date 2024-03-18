<template>
  <ValidationProvider
    tag="div"
    :rules="rules"
    :name="name"
    :vid="vid"
    ref="provider"
    :detectInput="false"
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
        <span class="relative flex w-full rounded-md shadow-sm">
          <input
            class="form-input block w-full text-sm"
            @focus="openDropdown"
            v-model="searchFilter"
            :placeholder="pholder"
            :class="[{ error: errors[0] }, injectClass]"
            v-bind="$attrs"
          />
          <div
            v-show="selected && clearable"
            class="absolute inset-y-0 right-6 flex items-center p-2 cursor-pointer h-full"
            @click="clearSelected"
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
              class="h-5 w-5 text-gray-400"
              viewBox="0 0 20 20"
              fill="none"
              stroke="currentColor"
            >
              <path
                d="M7 7l3-3 3 3m0 6l-3 3-3-3"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </span>
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
            class="absolute mt-2 w-full rounded bg-white shadow-lg z-50"
            :class="{ 'top-auto bottom-full mb-2': isAbove }"
          > -->
          <div
            v-show="isOpen"
            class="absolute mt-2 min-w-full rounded bg-white shadow-lg z-50"
            :class="{ 'top-auto bottom-full mb-2': isAbove }"
          >
            <ul
              tabindex="-1"
              role="listbox"
              aria-labelledby="listbox-label"
              aria-activedescendant="listbox-item-3"
              class="max-h-56 rounded py-1 text-base leading-6 shadow-sm overflow-auto focus:outline-none sm:text-sm sm:leading-5 dre"
            >
              <!--
              Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.
            -->
              <!-- <li
                tabindex="0"
                @click.stop="select(d)"
                id="listbox-item-0"
                role="option"
                v-for="(d, index) in filteredOptions"
                v-bind:key="index"
                class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9  cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:text-gray-900 focus:bg-gray-100"
                v-bind:class="{
                  'bg-gray-100 opacity-50': isSelected(d),
                }"
              > -->
              <li
                tabindex="0"
                @click.stop="select(d)"
                id="listbox-item-0"
                role="option"
                v-for="(d, index) in filteredOptions"
                v-bind:key="index"
                class="flex text-gray-900 cursor-default select-none relative py-2 pl-3 pr-6  cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:text-gray-900 focus:bg-gray-100"
                v-bind:class="{
                  'bg-gray-100 opacity-50': isSelected(d),
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
                  v-show="isSelected(d)"
                  class="absolute inset-y-0 right-0 flex items-center pr-4"
                > -->
                <span
                  v-show="isSelected(d)"
                  class="absolute inset-y-0 right-0 flex items-center"
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

              <!--
              When no result found.
            -->
              <li
                v-if="filteredOptions.length == 0"
                class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 cursor-pointer focus:outline-none focus:text-white focus:bg-indigo-600"
              >
                <slot name="noResult">No elements found.</slot>
              </li>
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
  name: "SelectSearchInput",
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
    pholder: {
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
    label: {
      type: String,
    },
    clearable: {
      type: Boolean,
      default: false,
    },
    value: {
      type: [String, Object],
      default: "",
    },
  },
  data() {
    return {
      isOpen: false,
      searchFilter: "",
      selected: "",
      isAbove: false,
    };
  },
  methods: {
    isSelected(option) {
      return this.selected === option;
    },
    closeDropdown() {
      this.searchFilter = this.getOptionLabel(this.selected);
      this.isOpen = false;
    },
    openDropdown() {
      this.adjustPosition();
      this.searchFilter = "";
      this.isOpen = true;
    },
    select(option) {
      this.selected = this.selected == option ? "" : option;
      this.searchFilter = this.getOptionLabel(this.selected);
      this.isOpen = false;

      this.$emit("input", this.selected);
      this.$refs.provider.validate(this.selected);
    },
    clearSelected() {
      this.selected = "";
      this.searchFilter = "";
      this.$emit("input", this.selected);
      this.$refs.provider.validate(this.selected);
    },
    adjustPosition() {
      if (typeof window === "undefined") return;

      const spaceAbove = this.$el.getBoundingClientRect().top;
      const spaceBelow =
        window.innerHeight - this.$el.getBoundingClientRect().bottom;
      const hasEnoughSpaceBelow = spaceBelow > this.maxHeight;

      if (hasEnoughSpaceBelow || spaceBelow > spaceAbove) {
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
  computed: {
    filteredOptions() {
      if (this.searchFilter != null) {
        // console.log(this.searchFilter)
        return this.options.filter(d =>
          String(this.getOptionLabel(d))
            .toLowerCase()
            .includes(this.searchFilter.toLowerCase())
        );
      }
      return this.options;
    },
  },
   watch: {
    value(newval) {
      // if (!!newval === false) return ''
      // this.searchFilter = newval;
      if(newval == ""){
        // console.log('masu')
        this.searchFilter = ''
      }
      // console.log('newfall: ',newval)
      this.selected = newval;
    },
  },
  components: {
    ValidationProvider,
  },
};
</script>
