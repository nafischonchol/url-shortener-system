// axios-instance.js
import axios from 'axios';
import { useToast } from "vue-toastification";

const http = axios.create({
  baseURL: '/api/v1',
});

const toast = useToast();

http.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('apiToken');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Add a response interceptor
http.interceptors.response.use(
  (response) => {
    if(response.data.message)
        toast.success(response.data.message);
    return response;
  },
  (error) => {
    // Global error handler
    if (error.response) {
      const status = error.response.status;
      const data = error.response.data;
      if (status === 401) {
       toast.error("Credentials not match! Login again");
      } else if (status === 403) {
        toast.error("Don't have permission");
      }  
      else {
        console.log(data);
        if (typeof data === 'string') 
          toast.error(data);
      }
    } 
    else if (error.request) {
        toast.error("Something wrong try again!");
        console.error('Request Error:', error.request);
    } else {
      // Something happened in setting up the request that triggered an Error
      toast.error("Something wrong try again!");
      console.error('Error:', error.message);
    }
    return Promise.reject(error);
  }
);

export default http;
