// services/diseaseService.js
import axiosInstance from './axiosInstance';

// Tambahkan interceptor untuk token
axiosInstance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

export const getDiseases = () => {
  return axiosInstance.get('disease-details');
};

export const getDiseaseByName = (name) => {
  return axiosInstance.get(`disease-details/detail/${encodeURIComponent(name)}`);
};

export const getDiseasesByStatus = (status) => {
  return axiosInstance.get(`disease-details/status?risk=${status}`);
};