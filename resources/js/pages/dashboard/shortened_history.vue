<template>
  <div class="row mt-5">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle table-striped">
          <thead>
            <tr>
              <th>Date</th>
              <th>Shortened URL</th>
              <th>Long URL</th>
              <th>Clicks</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in links" :key="item.id">
              <td width="10%">
                <span>{{ item.created_at }}</span>
              </td>
              <td>
                <a :href="item.shortened_url" target="_blank">{{ item.shortened_url }}</a>
              </td>
              <td width="65%">
                <span class="text-break">{{ item.long_url }}</span>
              </td>
              <td>
                <span>{{ item.clicks }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <pagination v-if="paginate" :current-page="paginate.current_page" :total-items="paginate.total_item"
        :total-pages="paginate.total_page" @page-change="fetchLinks">
      </pagination>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from "@/mixins/axios-config";
import Pagination from '@/components/pagination.vue';

const links = ref([]);
const paginate = ref({});

onMounted(async () => {
  await fetchLinks();
});

const fetchLinks = async (current_page = 1) => {
  const response = await axios.get(`/links?page=${current_page}`);
  links.value = response.data.item?.links;
  paginate.value = response.data.item?.meta;
};

defineExpose({
  fetchLinks
});
</script>