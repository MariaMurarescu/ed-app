import {createStore} from 'vuex';
import axiosClient from '../axios';

const store = createStore({
    state:{
        user: {
            data:{},
            token: sessionStorage.getItem("TOKEN"),
            role_id:'',
        },
        currentLesson: {
          data: {},
          loading: false,
        },
        lessons:{
          loading: false,
          links: [],
          data:[],
          from: null,
          page: 1,
          limit: null,
          total: null
        },
        lessonQuestionAnswers: {
          loading: false,
          data:{}
        },
      
        questionTypes:["text", "select", "radio", "checkbox", "textarea"],
        notification:{
          show: false,
          type: null,
          message: null
        },

        DeVorba: {
          loading: false,
          data: {}
        },

        enrollmentCode:null,
        studentLessons: {
          data: [],
        }
    },
    getter:{},
    actions:{
        register({commit}, user) {
            return axiosClient.post('/register', user)
              .then(({data}) => {
                commit('setUser', data.user);
                commit('setToken', data.token);
                return data;
              })
          },
          login({commit}, user) {
            console.log('Logging in with user:', user);
            return axiosClient.post('/login', user)
              .then(({data}) => {
                commit('setUser', data.user);
                commit('setToken', data.token);
                console.log('User data after login:', data.user);
                return data;
              })
          },
          logout({commit}) {
            return axiosClient.post('/logout')
              .then(response => {
                commit('logout')
                return response;
              })
          },
          getUser({commit}) {
            return axiosClient.get('/user')
            .then(res => {
              console.log(res);
              commit('setUser', res.data)
            })
          },

          getLessons({ commit }, {url = null, perPage=6, search = ''} = {}) {
            commit('setLessonsLoading', true)
            url = url || "/lesson";
            return axiosClient.get(url, {
              params: {search, per_page: perPage}
            })
            .then((res) => {
              commit('setLessonsLoading', false)
              commit('setLessons', res.data);
              return res;
            });
          },

          getLesson({ commit }, id) {
            commit('setCurrentLessonLoading', true);
            return axiosClient
              .get(`/lesson/${id}`)
              .then((res) => {
                commit('setCurrentLesson', res.data);
                commit('setCurrentLessonLoading', false);
                return res;
              })
              .catch((err) => {
                commit('setCurrentLessonLoading', false);
                throw err;
              });
          },

          saveLesson({ commit, dispatch}, lesson) {
            delete lesson.image_url;
            let response;
            if (lesson.id) {
              response = axiosClient
                .put(`/lesson/${lesson.id}`, lesson)
                .then((res) => {
                  commit('setCurrentLesson', res.data)
                  return res;
                });
            } else {
              response = axiosClient.post("/lesson", lesson).then((res) => {
                commit('setCurrentLesson', res.data);
                return res;
              });
            }
            return response;
          },

          getLessonBySlug({ commit }, slug) {
            commit("setCurrentLessonLoading", true);
            return axiosClient
              .get(`/lesson-by-slug/${slug}`)
              .then((res) => {
                commit("setCurrentLesson", res.data);
                commit("setCurrentLessonLoading", false);
                return res;
              })
              .catch((err) => {
                commit("setCurrentLessonLoading", false);
                throw err;
              });
          },

          deleteLesson({dispatch}, id) {
            return axiosClient.delete(`/lesson/${id}`).then((res) =>{
              dispatch('getLessons')
            });
          },
          
          saveLessonAnswer({ commit }, { lessonId, answers, email }) {
            return axiosClient.post(`/lesson/${lessonId}/answer`, { answers, email });
          },

          getDeVorbaData({commit}) {
            commit('DeVorbaLoading', true)
            return axiosClient.get(`/DeVorba`)
            .then((res) => {
              commit('DeVorbaLoading', false)
              commit('setDeVorbaData', res.data)
              return res;
            })
            .catch(error => {
              commit('DeVorbaLoading', false)
              return error;
            })
          },

          getLessonQuestionAnswers({ commit }, id) {
            commit('setLessonQuestionAnswersLoading', true);
            return axiosClient
              .get(`/lessons/${id}/answers`)
              .then((res) => {
                console.log('Successful response:', res);
                commit('setLessonQuestionAnswers', res.data);
                commit('setLessonQuestionAnswersLoading', false);
                return res;
              })
              .catch((err) => {
                commit('setLessonQuestionAnswersLoading', false);
                throw err;
              });
          },
          generateEnrollmentCode({commit}) {
            return axiosClient
            .post('/generate-enrollment-code')
            .then(response => {
              commit('SET_ENROLLMENT_CODE', response.data.code);
            })
            .catch(error => {
              console.error(error.response.data.message);
            });
          },
          enrollStudent({ commit }, code) {
            return axiosClient
            .post('/enroll-student', { code })
            .then(response => {
              console.log(response.data.mesage);
            })
            .catch(error =>{
              console.error(error.response.data.message);
            });
          },

          fetchLessonsByRoleId({ commit }, roleId) {
            return axiosClient.get(`/lessons/role/${roleId}`)
              .then(response => {
                commit('setStudentLessons', response.data.lessons);
                return response;
              })
              .catch(error => {
                return error;
              });
          },
        
      },
  
    mutations:{
        logout: state => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem('TOKEN');
        },
        setUser: (state, user) => {
          console.log('Setting user:', user);
          state.user.data = user;
          state.user.role_id = user.role_id;
        },
        setToken: (state, token) => {
          state.user.token = token; //token returned from the php laravel controller
          if (token) {
            sessionStorage.setItem('TOKEN', token);
          } else {
            sessionStorage.removeItem('TOKEN')
          }
          
        },
        setLessons: (state, lessons) => {
          state.lessons.links = lessons.meta.links;
          state.lessons.data = lessons.data;
        },
        setLessonsLoading: (state, loading) => {
          state.lessons.loading = loading;
        },
        setCurrentLessonLoading: (state, loading) => {
          state.currentLesson.loading = loading;
        },
        setCurrentLesson: (state, lesson) => {
          state.currentLesson.data = lesson.data;
        },

        DeVorbaLoading: (state, loading) =>{
          state.DeVorba.loading = loading;
        },
        setDeVorbaData:(state, data) => {
          state.DeVorba.data = data
        },
        setLessonQuestionAnswersLoading: (state, loading) => {
          state.lessonQuestionAnswers.loading = loading;
        },
        setLessonQuestionAnswers(state, answers) {
          console.log('Setting lesson question answers:', answers);
          state.lessonQuestionAnswers.data = answers; 
        },
        SET_ENROLLMENT_CODE(state, code) {
          state.enrollmentCode = code;
        },
        setStudentLessons(state, lessons) {
          state.studentLessons.data = lessons;
        },        

        notify: (state, {message, type}) => {
          state.notification.show = true;
          state.notification.type = type;
          state.notification.message = message;
          setTimeout(() => {
            state.notification.show = false;
          }, 3000)
        },
    },
    modules:{}
});

export default store;