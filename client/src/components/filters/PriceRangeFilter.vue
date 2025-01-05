<template>
  <div class="price-container">
    <el-input
        v-model="localPriceFrom"
        size="mini"
        :placeholder="fromPlaceholder"
        @input="debounceValidatePriceFrom"
        class="price-input"
    />
    <span class="price-separator">-</span>
    <el-input
        v-model="localPriceTo"
        size="mini"
        :placeholder="toPlaceholder"
        @input="debounceValidatePriceTo"
        class="price-input"
    />
  </div>
</template>

<script>
export default {
  name: "PriceRangeFilter",
  props: {
    priceFrom: {
      type: [Number, null],
      default: null,
    },
    priceTo: {
      type: [Number, null],
      default: null,
    },
    fromPlaceholder: {
      type: String,
      default: "From",
    },
    toPlaceholder: {
      type: String,
      default: "To",
    },
  },
  data() {
    return {
      localPriceFrom: this.priceFrom,
      localPriceTo: this.priceTo,
    };
  },
  watch: {
    priceFrom: {
      handler(newVal) {
        this.localPriceFrom = newVal;
      },
      immediate: true,
    },
    priceTo: {
      handler(newVal) {
        this.localPriceTo = newVal;
      },
      immediate: true,
    },
  },
  methods: {
    validatePrice(value) {
      let sanitizedValue = value
          .replace(/[^0-9.-]/g, "")
          .replace(/(?!^)-/g, "")
          .replace(/(\..*?)\..*/g, "$1");

      if (sanitizedValue === "-" || sanitizedValue === "") {
        return null;
      }

      let numberValue = parseFloat(sanitizedValue);
      if (isNaN(numberValue)) {
        return 0;
      }

      return Math.min(numberValue, 10000000);
    },
    debounceValidatePriceFrom: debounce(function (value) {
      const validatedValue = this.validatePrice(value);
      this.$emit("update:priceFrom", validatedValue);
      this.$emit("change");
    }, 300),
    debounceValidatePriceTo: debounce(function (value) {
      const validatedValue = this.validatePrice(value);
      this.$emit("update:priceTo", validatedValue);
      this.$emit("change");
    }, 300),
  },
};

function debounce(func, wait) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), wait);
  };
}
</script>

<style scoped>
.price-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-width: 200px;
  gap: 10px;
}

.price-input {
  width: 100%;
}

.price-separator {
  font-size: 16px;
  font-weight: bold;
  color: #333;
}
</style>
