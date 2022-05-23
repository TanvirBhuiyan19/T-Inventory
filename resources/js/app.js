

require('./bootstrap');

//window.Vue = require('vue').default;
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)



//Routes import
import { routes } from './routes';

//Routes import
import User from './helpers/User';
window.User = User;

//Sweet alert
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 4000,
  timerProgressBar: false,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast = Toast;
//End: Sweet alert

//Emit
window.Reload = new Vue();



const router = new VueRouter({
    routes,
    mode: 'history'
  })

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,

    data(){
      return{
          userName: '',
          userId: localStorage.getItem('userid'),
      }
    },
    created(){ 
      if(User.loggedIn()){
        this.userInfo()
      }
    },
    methods:{
      userInfo(){
        axios.get('/api/user-info/'+this.userId )
        .then( ({data}) => { 
          this.userName = data.name
        })
      },
    },

});
