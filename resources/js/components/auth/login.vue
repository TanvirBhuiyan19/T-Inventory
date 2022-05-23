<template>

	 <div>
    <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" @submit.prevent="login">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" v-model="form.email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                      <small class="text-danger font-weight-bold" v-if="errors.email">{{ errors.email[0] }}</small>
                    </div>
                    
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" v-model="form.password" placeholder="Password">
                      <small class="text-danger font-weight-bold" v-if="errors.password">{{ errors.password[0] }}</small>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" checked>
                        <label class="custom-control-label" for="customCheck" >Remember Me</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <br><hr><br>
                  <div class="text-center">
                    <router-link to="/register" class="btn btn-success">Create an Account!</router-link>
                  </div>
                  <div class="text-center">
                    <router-link to="/forget" class="small">Forgot Password?</router-link>
                  </div>
                  <br><hr><br>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  </div>

</template>

<script type="text/javascript">
 export default { 
   created(){
     if(User.loggedIn()){
       this.$router.push({ name: 'home' })
     }
   },
  data(){
    return{
      form:{
        email: null,
        password: null
      },
      errors:{},
    }
  },

  methods:{
    login(){
      axios.post('/api/auth/login',this.form)
      .then(res => {
        User.responseAfterLogin(res)

        Toast.fire({
          icon: 'success',
          title: 'Welcome back !!'
        })

        this.$router.push({ name: 'home' })
      })
      .catch(error => {
        this.errors = error.response.data.errors

        Toast.fire({
          icon: 'error',
          title: 'Invalid Email or Password !!'
        })

      })
    }
  }

}
</script>

<style type="text/css">
	
</style>