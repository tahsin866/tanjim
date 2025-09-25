import axios from 'axios';

// Create axios instance for API calls
const api = axios.create({
    baseURL: '/api',
    withCredentials: true, // Include cookies for CSRF protection
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

// Request interceptor to add Authorization header from token
api.interceptors.request.use(
    (config) => {
        // Try to get token from localStorage first, then from session
        let token = localStorage.getItem('admin_token');
        
        // If no token in localStorage, try to get from Laravel session (for our mixed auth)
        if (!token && window.Laravel && window.Laravel.admin_token) {
            token = window.Laravel.admin_token;
        }
        
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Response interceptor to handle authentication errors
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Clear token on authentication error
            localStorage.removeItem('admin_token');
            
            // Redirect to login if not already there
            if (!window.location.pathname.includes('/admin/login')) {
                window.location.href = '/admin/login';
            }
        }
        return Promise.reject(error);
    }
);

export default api;
