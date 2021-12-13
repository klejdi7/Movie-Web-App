// // FRONTEND ---------
import Home from './components/frontend/Home.vue';
import Profile from './components/frontend/Profile.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'profile',
        path: '/profile/:id',
        component: Profile
    },
];