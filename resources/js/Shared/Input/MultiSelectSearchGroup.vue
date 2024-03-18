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
          <div
            class="form-input w-full flex flex-wrap items-center focus-within:form-input cursor-text max-h-24 overflow-auto dre"
            :class="{ 'opacity-75 bg-gray-100': disabled }"
            @click="setFocus"
          >
            <div
              v-for="(tag, index) in selected"
              :key="index"
              class="flex items-center space-x-1 rounded-full bg-gray-200 text-gray-700 px-2 py-1 mr-1 mt-1 text-xs"
            >
              <span v-if="getOptionLabel(tag).length > 20"
                >{{ getOptionLabel(tag).substring(0, 20) }}...</span
              >
              <span v-else>{{ getOptionLabel(tag) }}</span>
              <IconCross
                class="cursor-pointer"
                size="h-3 w-3"
                @click.native.stop="removeSelected(tag)"
              />
            </div>
            <input
              class="focus:outline-none bg-transparent w-full text-sm"
              @focus="openDropdown"
              v-model="searchFilter"
              :placeholder="setPlaceholder"
              ref="myTagInput"
              :disabled="disabled"
            />
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
          <div
            v-show="isOpen"
            class="absolute mt-2 w-full rounded bg-white shadow-md z-50 border"
            :class="{ 'top-auto bottom-full mb-2': isAbove }"
          >
            <ul
              tabindex="-1"
              role="listbox"
              aria-labelledby="listbox-label"
              aria-activedescendant="listbox-item-3"
              class="max-h-56 rounded py-1 text-base leading-6 shadow-sm overflow-auto focus:outline-none sm:text-sm sm:leading-5 dre"
            >
              <template v-for="(d, index) in filteredOptions">
                <li
                  v-bind:key="d[groupLabel] + index"
                  class="text-gray-600 font-medium bg-gray-200 pl-1 py-1"
                  v-if="d[groupList].length > 0"
                >
                  <div class="flex items-center space-x-3">
                    <span class="block truncate">
                      {{ getOptionGroup(d) }}
                    </span>
                  </div>
                </li>
                <li
                  tabindex="0"
                  @click="select(f)"
                  id="listbox-item-0"
                  role="option"
                  v-for="(f, index) in d[groupList]"
                  v-bind:key="`label-` + f[label] + index"
                  class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9  cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:outline-none"
                  v-bind:class="{
                    'bg-gray-100 opacity-50': isSelected(f),
                  }"
                >
                  <div class="flex items-center space-x-3">
                    <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                    <span class="block truncate">
                      {{ getOptionLabel(f) }}
                    </span>
                  </div>

                  <!--
              Checkmark, only display for selected option.

              Highlighted: "text-white", Not Highlighted: "text-indigo-600"
            -->
                  <span
                    v-show="isSelected(f)"
                    class="absolute inset-y-0 right-0 flex items-center pr-4"
                  >
                    <svg
                      class="h-5 w-5"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </span>
                </li>
              </template>
              <li
                v-if="filteredOptions.length == 0 && searchFilter != ''"
                class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 cursor-pointer focus:outline-none focus:text-white focus:bg-indigo-600"
              >
                <slot name="noResult">No elements found.</slot>
              </li>
              <li
                v-if="filteredOptions.length == 0 && searchFilter == ''"
                class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 cursor-pointer focus:outline-none focus:text-white focus:bg-indigo-600"
              >
                <slot name="listEmpty">List is empty.</slot>
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
import IconCross from "@/Shared/Icons/Cross";
import { mixin as clickaway } from "vue-clickaway";

export default {
  name: "MultiSelectSearchGroup",
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
    groupLabel: {
      type: String,
    },
    groupList: {
      type: String,
    },
    label: {
      type: String,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    value: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      isOpen: false,
      searchFilter: "",
      selected: [],
      isAbove: false,
    };
  },
  methods: {
    isSelected(option) {
      return this.selected.includes(option);
    },
    closeDropdown() {
      this.searchFilter = "";
      this.isOpen = false;
    },
    openDropdown() {
      this.adjustPosition();
      this.searchFilter = "";
      this.isOpen = true;
    },
    select(option) {
      this.isOpen = false;
      // remove if already selected
      if (this.selected.includes(option)) {
        let idx = this.selected.findIndex(e => e == option);
        this.selected.splice(idx, 1);
      } else {
        this.selected.push(option);
      }
      this.searchFilter = "";

      this.$emit("input", this.selected);
      this.$refs.provider.validate(this.selected);
    },
    removeSelected(option) {
      let idx = this.selected.findIndex(e => e == option);
      this.selected.splice(idx, 1);
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
    getOptionGroup(option) {
      let groupLabel = this.customLabel(option, this.groupLabel);
      return groupLabel;
    },
    getOptionLabel(option) {
      let label = this.customLabel(option, this.label);
      return label;
    },
    setFocus() {
      this.$refs.myTagInput.focus();
    },
  },
  computed: {
    filteredOptions() {
      let $vm = this;

      if (this.searchFilter != "") {
        let opts = [];
        let filtered = this.options.map(opt => {
          opts = opt[$vm.groupList].filter(e =>
            String($vm.getOptionLabel(e))
              .toLowerCase()
              .includes($vm.searchFilter.toLowerCase())
          );
          return opts.length > 0
            ? {
                ...opt,
                [$vm.groupList]: opts,
              }
            : null;
        });

        return filtered.filter(e => e != null);
      }
      return this.options.filter(e => e[$vm.groupList].length > 0);
      // return this.options;
    },
    setPlaceholder() {
      return this.selected.length > 0 ? "" : this.pholder;
    },
  },
  components: {
    ValidationProvider,
    IconCross,
  },
  watch: {
    value(newval) {
      this.selected = newval;
    },
  },
};
</script>
