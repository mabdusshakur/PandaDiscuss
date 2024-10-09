import axios from 'axios';

// Create an axios instance
const axiosInstance = axios.create({
    baseURL: 'http::127.0.0.1:8000/api', // Replace with your API base URL
    headers: {
        'Content-Type': 'application/json',
    },
});

// Add a request interceptor to include the bearer token from local storage
axiosInstance.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, (error) => {
    return Promise.reject(error);
}
);

// Add a response interceptor to handle unauthorized responses
axiosInstance.interceptors.response.use((response) => {
    return response;
}, (error) => {
    if (error.response && error.response.status === 401) {
        router.visit('/login');
    }
    return Promise.reject(error);
}
);

export default axiosInstance;