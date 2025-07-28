// resources/frontend/src/services/api.js

import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // tu backend Laravel
  //withCredentials: true, // si usas cookies/Sanctum
  headers: {
    'Accept': 'application/json',
  }
});

export default api;
