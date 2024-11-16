// services/diseaseHistoryService.js
import axiosInstance from './axiosInstance';

export const getDiseaseHistory = (year) => {
  return axiosInstance.get(`disease-details?year=${year}`);
};

export const getCheckupHistory = (year) => {
  return axiosInstance.get(`checkup-history?year=${year}`);
};