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

      <ShortenedHistory ref="shortenedHistoryRef" v-if="isLoggedIn()"/>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from "@/mixins/axios-config";
import { useToast } from "vue-toastification";
import Errors from "@/errors/errors.js";
import ShortenedHistory from '@/pages/dashboard/shortened_history.vue';

const toast = useToast();
const allErrors = ref(new Errors());

const is_shortened = ref(false);
const shortened_link = ref('');
const original_link = ref('');
const form = ref({
  url: "",
});

const shortenedHistoryRef = ref(null);

const shortenUrl = async () => {
  try {
    const response = await axios.post("/shorten", form.value);
    is_shortened.value = true;

    shortened_link.value = response.data.item;
    original_link.value = form.value.url;
    form.value.url = shortened_link.value;
    shortenedHistoryRef.value.fetchLinks();
  } catch (error) {

    console.log(error);
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
