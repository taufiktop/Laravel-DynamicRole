<template>
  <ValidationProvider
    tag="div"
    :rules="rules"
    :name="name"
    :vid="vid"
    mode="eager"
    v-slot="{ validate, errors }"
    ref="provider"
  >
    <div class="block">
      <span class="text-gray-700 text-sm" v-if="label">{{ label }}</span>
      <div
        class="form-input flex flex-wrap items-center focus-within:form-input cursor-text max-h-24 overflow-auto dre"
        :class="[{ error: errors[0] }]"
        @click="setFocus"
      >
        <div
          v-for="(tag, index) in tags"
          :key="tag + index"
          class="flex items-center space-x-1 rounded-full bg-gray-200 text-gray-700 px-2 py-1 mr-1 mt-1 text-xs"
        >
          <span v-if="tag.length > 20">{{ tag.substring(0, 20) }}...</span>
          <span v-else>{{ tag }}</span>
          <IconCross
            class="cursor-pointer"
            size="h-3 w-3"
            @click.native="removeTag(index)"
          />
        </div>
        <input
          :type="type"
          v-bind="$attrs"
          class="focus:outline-none bg-transparent text-sm"
          :class="[injectClass]"
          :size="size"
          @input="input"
          ref="myTagInput"
          @keydown.188="addTag"
          @keydown.delete="removeLastTag"
        />
      </div>
      <span class="form-error">{{ errors[0] }}</span>
    </div>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from "vee-validate";
import IconCross from "@/Shared/Icons/Cross";

export default {
  name: "TextInput",
  components: {
    ValidationProvider,
    IconCross,
  },
  props: {
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
    capitalize: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      tags: [],
      size: 1,
    };
  },
  methods: {
    addTag(event) {
      event.preventDefault();
      let val = event.target.value.trim();
      if (val.length > 0) {
        this.tags.push(this.capitalize ? val.toUpperCase() : val);
        this.$emit("input", this.tags.join());
        event.target.value = "";
        this.size = 1;
      }
      this.$refs.provider.validate(this.tags);
    },
    removeTag(index) {
      this.tags.splice(index, 1);
      this.$emit("input", this.tags.join());
      this.$refs.provider.validate(this.tags);
    },
    removeLastTag(event) {
      if (event.target.value.length === 0) {
        this.removeTag(this.tags.length - 1);
      }
    },
    setFocus() {
      this.$refs.myTagInput.focus();
    },
    input(event) {
      event.preventDefault();
      let s =
        event.target.value.length > 40 ? 40 : event.target.value.length + 5;
      this.size = Math.max(1, s);
    },
  },
  watch: {
    value() {
      this.tags = !this.value ? [] : this.value.split(",");
      this.$refs.provider.validate(this.tags);
    },
  },
};
</script>
