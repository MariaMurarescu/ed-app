import { createRouter, createWebHistory } from "vue-router";
import DeVorba from '../views/DeVorba.vue';
import Lessons from '../views/Lessons.vue';
import LessonView from '../views/LessonView.vue';
import LessonPublicView from '../views/LessonPublicView.vue';
import Agenda from '../views/Agenda.vue';
import Progres from '../views/Progres.vue';
import Student from '../views/Student.vue';
import Register from '../views/Register.vue';
import RequestPassword from '../views/RequestPassword.vue';
import ResetPassword from '../views/ResetPassword.vue';
import Login from '../views/Login.vue';
import NotFound from '../views/NotFound.vue';
import AdminLayout from '../views/layouts/AdminLayout.vue';
import Users from '../views/Users/Users.vue';
import Report from '../views/Reports/Report.vue';
import Dashboard from '../views/Dashboard.vue';

import AuthLayout from '../components/AuthLayout.vue';
import store from '../store';
import { computed } from 'vue';

import StudentLayout from '../views/layouts/Student.vue';
import TeacherLayout from '../views/layouts/Teacher.vue';


//array that defines the routes for the application
const routes = [
  {
    path: '/',
    redirect: '/app'
  },
  {
    path: '/app',
    name: 'app',
    redirect: '/app/dashboard',
    component: AdminLayout, // Assuming you have an AdminLayout component
    children: [
      {
        path: 'dashboard',
        name: 'app.dashboard',
        component: Dashboard,
      },
      {
        path: 'users',
        name: 'app.users',
        component: Users,
      },
      {
        path: 'report',
        name: 'app.report',
        component: Report,
      },
    ],
  },

    {
        path: "/view/lesson/:slug",
        name: 'LessonPublicView',
        component: LessonPublicView
      },
    {
        path: '/auth',
        redirect: '/login',
        name: 'Auth',
        component: AuthLayout,
        meta: {isGuest: true},
        children:[
            {
                path:'/login',
                name: 'Login',
                component: Login
            },
            {
                path: '/register',
                name:'Register',
                component: Register,
                meta: { isGuest: true }
            },
            {
                path: '/request-password',
                name:'requestPassword',
                component: RequestPassword
            },
            {
                path: '/reset-password/:token',
                name:'resetPassword',
                component: ResetPassword
            },
            {
                path: '/:pathMatch(.*)',
                name: 'notfound',
                component: NotFound,
              }
        ]
    },

    {
        path: "/student",
        name: 'student',
        component: StudentLayout, // Student-specific layout
        meta: { requiresAuth: true, requiresStudent: 1 },
        children: [
            {path: '/agenda', name: 'Agenda', component: Agenda},
            {path: '/progres', name: 'Progres', component: Progres},
        ],
      },

      {
        path: "/teacher",
        name:'teacher',
        component: TeacherLayout, // Teacher-specific layout
        meta: { requiresAuth: true, requiresTeacher: 2 },
        children: [
          {path: '/DeVorba', name: 'DeVorba', component: DeVorba},
          {path: '/Lessons', name: 'Lessons', component: Lessons},
          {path: '/agenda', name: 'Agenda', component: Agenda},
          {path: '/progres', name: 'Progres', component: Progres},
          {path: '/student', name: 'Student', component: Student},
          {path: '/lessons/create', name: 'LessonCreate', component: LessonView},
          {path: '/lessons/:id', name: 'LessonView', component: LessonView },
        ],
      },
] 

const router = createRouter({
    history: createWebHistory(), // function is used to create an HTML5 history mode router, 
                                 // which uses the browser's history.
                                 // pushState API to change the URL and handle navigation between routes without causing a full page reload.
    routes,
});

//indicate from which road user is trying to redirect
//test if user is logged or not, redirect to the login page


const userRole = computed(() => {
    const user = store.state.user;
  });

  router.beforeEach((to, from, next) => {
    const userRole = store.state.user.role_id;
  
    if (to.meta.requiresAuth && !store.state.user.token) {
      console.log("Redirecting to Login");
      next({ name: "Login" });
    } else if (userRole === 1 && to.meta.requiresTeacher) {
      console.log("Allowing Student");
      next({name: "student"});
    } else if (userRole === 2 && to.meta.requiresStudent) {
      console.log("Allowing Teacher");
      next({name: "teacher"});
    } else {
      next();
    }
  });
  
  
export default router;