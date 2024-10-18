<template>
  <div>
    <div class="container mt-4">
      <div class="row justify-content-center">
        <main class="col-md-6">
          <div class="input-group my-3">
            <input v-model="form.url" type="text" class="form-control" id="url" placeholder="Enter a link to shorten"
              :readonly="is_shortened" @keydown="allErrors.clear('url')" />

            <button v-if="!is_shortened" class="btn btn-primary" type="button" @click="shortenUrl">
              Shorten
            </button>

            <button v-else class="btn btn-secondary" type="button" @click="copyToClipboard">
              Copy
            </button>
          </div>

          <span v-if="allErrors.has('url')" class="error text-danger text-bold ms-2 mt-2" v-text="allErrors.get('url')">
          </span>

          <div v-if="original_link" class="alert alert-info">
            Long URL:
            <a :href="original_link" target="_blank" class="text-break">{{ original_link }}</a>
          </div>

          <div v-if="shortened_link" class="text-center mt-3">
            <button class="btn btn-outline-primary" @click="resetForm">
              Shorten Another URL
            </button>
          </div>
        </main>
      </div>

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
                <tr v-for="item in links " :key="item.id">
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
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from "@/mixins/axios-config";
import { useToast } from "vue-toastification";
import Errors from "@/errors/errors.js";
import Pagination from '@/components/pagination.vue';

const toast = useToast();
const allErrors = ref(new Errors());

const is_shortened = ref(false);
const shortened_link = ref('');
const original_link = ref('');
const paginate = ref({});
const form = ref({
  url: "",
});

const links = ref([]);

onMounted(async () => {
  await fetchLinks();
});

const fetchLinks = async (current_page = 1) => {
  const response = await axios.get(`/links?page=${current_page}`);
  links.value = response.data.item?.links;
  paginate.value = response.data.item?.meta;
};

const shortenUrl = async () => {
  try {
    const response = await axios.post("/shorten", form.value);
    is_shortened.value = true;

    shortened_link.value = response.data.item;
    original_link.value = form.value.url;
    form.value.url = shortened_link.value;
    await fetchLinks();

  } catch (error) {

    if (error && error.response.status === 422) {
      allErrors.value.record(error.response.data.errors);
    }
  }
};

const copyToClipboard = () => {
  navigator.clipboard.writeText(shortened_link.value).then(() => {
    toast.success('Shortened URL copied to clipboard!');
  });
};

const resetForm = () => {
  is_shortened.value = false;
  form.value.url = '';
  shortened_link.value = '';
  original_link.value = '';
};
</script>
