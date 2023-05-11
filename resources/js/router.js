// import {createRouter, createWebHashHistory} from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router'
export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/:pathMatch(.*)*', component: () => import('./components/NotfoundComponent.vue')},
        {path: '/', component: () => import('./components/HomeComponent.vue')},
        {path: '/polls', component: () => import('./components/AllPollsComponent.vue')},
        {path: '/uploadapoll/do-upload/new-poll', component: () => import('./components/UploadAPoll.vue')},
        {path: '/poll/:pollid', component: () => import('./components/PollWithId.vue')},
        {path: '/polls/:industry', component: () => import('./components/IndustryWisePoll.vue')},


        // {path: '/Test', component: () => import('./pages/Test.vue')},
        // {path: '/tashur', component: () => import('./pages/tashur.vue')},
        // {path: '/egzon', component: () => import('./pages/Egzon.vue')},
        // {path: '/ilir', component: () => import('./pages/Ilir.vue')},
    ]
})
