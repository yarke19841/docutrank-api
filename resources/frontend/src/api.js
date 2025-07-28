// src/services/api.js
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // URL del backend Laravel
  withCredentials: true, // permite usar cookies para login si usas Sanctum
  headers: {
    'Accept': 'application/json',
  }
});

export default api;
