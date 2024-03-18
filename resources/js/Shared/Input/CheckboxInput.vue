<template>
  <ValidationProvider
    tag="div"
    :rules="rules"
    :name="name"
    :vid="vid"
    mode="eager"
    v-slot="{ errors }"
  >
    <div class="block">
      <span class="text-gray-700 text-sm" v-if="label">{{ label }}</span>
      <div class="flex space-x-2 text-sm">
        <label
          class="inline-flex items-center"
          v-for="(opt, index) in options"
          :key="index"
        >
          <input
            type="checkbox"
            class="form-checkbox text-teal-600 h-4 w-4"
            v-model="checkedData"
            v-bind="$attrs"
            :class="[{ error: errors[0] }, injectClass]"
            :value="getCheckboxLabel(opt, labelValue)"
          />
          <span class="ml-1 cursor-pointer select-none">{{
            getCheckboxLabel(opt, labelText)
          }}</span>
        </label>
      </div>
      <span class="form-error">{{ errors[0] }}</span>
    </div>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from "vee-validate";

export default {
  name: "CheckboxInput",
  components: {
    ValidationProvider,
  },
  props: {
    value: {
      type: Array,
      default: () => [],
    },
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
    type: {
      type: String,
      default: "text",
    },
    label: String,
    injectClass: {
      required: false,
      type: String,
    },
    options: {
      type: Array,
      default: () => [],
    },
    labelValue: {
      type: String,
    },
    labelText: {
      type: String,
    },
  },
  data() {
    return {
      checkedData: [],
    };
  },
  methods: {
    getCheckboxLabel(opt, label) {
      return label ? opt[label] : opt;
    },
  },
  watch: {
    checkedData() {
      return this.$emit("input", this.checkedData);
    },
  },
};
</script>
