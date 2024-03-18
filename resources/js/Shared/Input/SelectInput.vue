<template>
  <ValidationProvider
    tag="div"
    :rules="rules"
    :name="name"
    :vid="vid"
    v-slot="{ errors }"
  >
    <div class="block">
      <span class="text-gray-700 text-sm" v-if="label">{{ label }}</span>
      <select
        @change="$emit('input', $event.target.value)"
        class="form-select block text-sm"
        :class="[{ error: errors[0] }, injectClass]"
        v-bind="$attrs"
      >
        <option disabled value="">{{ defopt }}</option>
        <slot />
      </select>
      <span class="form-error">{{ errors[0] }}</span>
    </div>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from "vee-validate";

export default {
  name: "TextInput",
  components: {
    ValidationProvider,
  },
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
    label: String,
    injectClass: {
      required: false,
      type: String,
    },
    defaultOption: {
      required: false,
      type: String,
    },
  },
  computed: {
    defopt() {
      return this.defaultOption || "Please select one";
    },
  },
};
</script>
