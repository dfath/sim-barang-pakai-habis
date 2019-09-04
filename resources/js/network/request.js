import axios from "axios";

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const responseBody = res => Promise.resolve(res.data);
const handlerError = err => Promise.reject(err);

const request = {
  get: (url, config) =>
    axios.get(`${url}`, config).then(responseBody, handlerError),
  post: (url, body) =>
    axios.post(`${url}`, body).then(responseBody, handlerError),
  put: (url, body) =>
    axios.put(`${url}`, body).then(responseBody, handlerError),
  delete: (url) =>
   axios.delete(`${url}`).then(responseBody, handlerError)
};

export default request;
