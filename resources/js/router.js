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
        {path: '/poll-winner/:pollid', component: () => import('./components/PollWinner.vue')},
        {path: '/login', component: () => import('./components/Login.vue')},
        {path: '/create-account', component: () => import('./components/CreateAccount.vue')},
        {path: '/change-password', component: () => import('./components/ForgotPassword.vue')},
        {path: '/terms-and-conditions', component: () => import('./components/TermsAndConditions.vue')},
        {path: '/countries', component: () => import('./components/CountriesWithPopulations.vue')},
        {path: '/about-us', component: () => import('./components/AboutUs.vue')},
        {path: '/privacy-policy', component: () => import('./components/PrivacyPolicy.vue')},
        {path: '/report-a-problem', component: () => import('./components/ReportProblem.vue')},
        


        // {path: '/Test', component: () => import('./pages/Test.vue')},
        // {path: '/tashur', component: () => import('./pages/tashur.vue')},
        // {path: '/egzon', component: () => import('./pages/Egzon.vue')},
        // {path: '/ilir', component: () => import('./pages/Ilir.vue')},
    ]
})
