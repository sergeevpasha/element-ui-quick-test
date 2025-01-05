<template>
  <div id="app">
    <div class="center-container">
      <el-header>
        <el-input
            placeholder="Search properties..."
            v-model="input"
            clearable
            @input="fetchProperties"
            class="input-search">
        </el-input>
      </el-header>
      <div class="filters-container">
        <div class="filter-item">
          <div class="sub-title">Bedrooms:</div>
          <number-filter
              v-model="bedrooms"
              placeholder="Select"
              size="mini"
              @change="fetchProperties"
          />
        </div>
        <div class="filter-item">
          <div class="sub-title">Bathrooms:</div>
          <number-filter
              v-model="bathrooms"
              placeholder="Select"
              size="mini"
              @change="fetchProperties"
          />
        </div>
        <div class="filter-item">
          <div class="sub-title">Storeys:</div>
          <number-filter
              v-model="storeys"
              placeholder="Select"
              size="mini"
              @change="fetchProperties"
          />
        </div>
        <div class="filter-item">
          <div class="sub-title">Garages:</div>
          <number-filter
              v-model="garages"
              placeholder="Select"
              size="mini"
              @change="fetchProperties"
          />
        </div>
        <div class="filter-item full-width">
          <div class="sub-title">Price:</div>
          <price-range-filter
              :priceFrom="priceFrom"
              :priceTo="priceTo"
              from-placeholder="Price From"
              to-placeholder="Price To"
              @update:priceFrom="priceFrom = $event"
              @update:priceTo="priceTo = $event"
              @change="fetchProperties"
          />
        </div>
      </div>
      <div class="table-container">
        <el-table
            :data="properties"
            stripe
            border
            class="table">
          <el-table-column
              prop="name"
              label="Name"
              align="center">
          </el-table-column>
          <el-table-column
              prop="price"
              label="Price"
              align="center">
          </el-table-column>
          <el-table-column
              prop="bedrooms"
              label="Bedrooms"
              align="center">
          </el-table-column>
          <el-table-column
              prop="bathrooms"
              label="Bathrooms"
              align="center">
          </el-table-column>
          <el-table-column
              prop="storeys"
              label="Storeys"
              align="center">
          </el-table-column>
          <el-table-column
              prop="garages"
              label="Garages"
              align="center">
          </el-table-column>
        </el-table>
        <el-pagination
            v-if="total > 0"
            background
            layout="prev, pager, next, ->, total"
            :current-page="currentPage"
            :page-size="perPage"
            :total="total"
            @current-change="handlePageChange"
            class="custom-pagination"
            style="margin-top: 20px;"
        >
        </el-pagination>
      </div>
    </div>
  </div>
</template>

<script>
import NumberFilter from "@/components/filters/NumberFilter.vue";
import PriceRangeFilter from "@/components/filters/PriceRangeFilter.vue";

export default {
  name: 'App',
  components: {
    NumberFilter,
    PriceRangeFilter,
  },
  data() {
    return {
      input: '',
      bedrooms: null,
      bathrooms: null,
      storeys: null,
      garages: null,
      priceFrom: null,
      priceTo: null,
      properties: [],
      currentPage: 1,
      perPage: 10,
      total: 0,
    };
  },
  methods: {
    async getProperties() {
      const params = {
        page: this.currentPage,
        perPage: this.perPage,
        name: this.input,
        bedrooms: this.bedrooms,
        bathrooms: this.bathrooms,
        storeys: this.storeys,
        garages: this.garages,
        price_from: this.priceFrom,
        price_to: this.priceTo,
      };
      const filteredParams = Object.fromEntries(
          Object.entries(params).filter(([, value]) => value !== null && value !== undefined && value !== "")
      );
      const queryString = new URLSearchParams(filteredParams).toString();

      const url = `/api/properties?${queryString}`;

      const response = await fetch(url);
      const data = await response.json();

      this.properties = data.data;
      this.currentPage = data.meta.current_page;
      this.perPage = data.meta.per_page;
      this.total = data.meta.total;
    },
    fetchProperties() {
      this.currentPage = 1;
      this.getProperties(this.input);
    },
    handlePageChange(page) {
      this.currentPage = page;
      this.getProperties(this.input);
    },
  },
  async mounted() {
    await this.getProperties();
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.center-container {
  max-width: 1080px;
  margin: 0 auto;
  padding: 20px;
}

.input-search {
  width: 100%;
  max-width: 400px;
  margin: 10px auto;
}

.filters-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
  margin: 20px 0;
}

.filter-item {
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 200px;
  border: 1px solid #dcdcdc;
  padding: 10px;
  border-radius: 5px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.filter-item.full-width {
  flex: 1;
  max-width: 400px;
}

.price-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}

.price-separator {
  font-size: 16px;
  font-weight: bold;
  color: #333;
}

.table-container {
  margin-top: 20px;
  overflow-x: auto;
}

.sub-title {
  margin-bottom: 8px;
  font-size: 14px;
  color: #666;
  font-weight: bold;
}
.custom-pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  gap: 10px;
}

.el-pagination {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  font-size: 14px;
  color: #333;
}

.el-pagination .el-pager li {
  border: 1px solid #dcdcdc;
  background-color: #f9f9f9;
  color: #666;
  border-radius: 4px;
  margin: 0 4px;
  padding: 0 8px;
  cursor: pointer;
  transition: all 0.3s;
}

.el-pagination .el-pager li:hover {
  background-color: #e6e6e6;
  color: #333;
}

.el-pagination .el-pager li.active {
  background-color: #409eff;
  color: white;
  font-weight: bold;
  border-color: #409eff;
}

.el-pagination .el-icon {
  color: #409eff;
}

.el-pagination__total {
  margin-left: 10px;
  color: #666;
  font-size: 14px;
  font-weight: 500;
}

</style>
