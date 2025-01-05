<template>
  <el-select
      v-model="localValue"
      :placeholder="placeholder"
      size="mini"
      @change="handleChange"
      style="width: 100%">
    <el-option
        :label="'Any'"
        :value="null">
    </el-option>
    <el-option
        v-for="i in max"
        :key="i"
        :label="i"
        :value="i">
    </el-option>
  </el-select>
</template>

<script>
export default {
  name: 'NumberFilter',
  props: {
    max: {
      type: Number,
      default: 10,
    },
    value: {
      type: [Number, null],
      default: null,
    },
    placeholder: {
      type: String,
      default: 'Select',
    },
  },
  data() {
    return {
      localValue: this.value,
    };
  },
  watch: {
    value(newValue) {
      this.localValue = newValue;
    },
  },
  methods: {
    handleChange() {
      this.$emit('input', this.localValue);
      this.$emit('change');
    },
  },
};
</script>