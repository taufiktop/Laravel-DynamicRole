<template>
  <div class="block">
    <span class="text-gray-700" v-if="label">{{ label }}</span>
    <input
      ref="input"
      v-bind="$attrs"
      class="form-input block"
      :class="[{ error: error }, injectClass]"
      :type="type"
      :value="value"
      @input="$emit('input', $event.target.value)"
    />
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    type: {
      type: String,
      default: "text",
    },
    value: String,
    label: String,
    error: String,
    injectClass: {
      required: false,
      type: String,
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>
