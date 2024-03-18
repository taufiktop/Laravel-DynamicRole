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
      <textarea
        :cols = cols
        :rows = rows
        :form = form_id
        :wrap = wrap
        @input="$emit('input', $event.target.value)"
        v-bind="$attrs"
        class="form-input block text-sm"
        :class="[{ error: errors[0] }, injectClass]"
        :value="value"
      />
      <span class="form-error">{{ errors[0] }}</span>
    </div>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from "vee-validate";
// import { integer } from 'vee-validate/dist/rules';

export default {
  name: "TextInput",
  components: {
    ValidationProvider,
  },
  props: {
    cols: {
      type: Number,
      default: 1,
    },
    rows: {
      type: Number,
      default: 3,
    },
    form_id: {
      type: String,
      default: "form",
    },
    wrap: {
      type: String,
      default: "hard",
    },

    value: {
      type: String,
      default: "",
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
  },
};
</script>
