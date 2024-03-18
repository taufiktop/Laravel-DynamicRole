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
      <VueDatePicker
        v-model="date"
        v-bind="$attrs"
        class="form-input block text-sm p-1"
        :class="[{ error: errors[0] }, injectClass]"
      />
      <span class="form-error">{{ errors[0] }}</span>
    </div>
  </ValidationProvider>
</template>

<script>
import { VueDatePicker } from "@mathieustan/vue-datepicker";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";
import { ValidationProvider } from "vee-validate";

export default {
  name: "DateInput",
  components: {
    ValidationProvider,
    VueDatePicker,
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
  },
  data() {
    return {
      date: null,
    };
  },
  watch: {
    date() {
      this.$emit("input", this.date);
    },
  },
};
</script>
