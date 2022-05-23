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
              <div class="col-lg-6 d-none d-lg-block bg-register-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                  </div>
                  <form class="user" @submit.prevent="register">
                    <div class="form-group row">
                        <input type="text" class="form-control form-control-user" id="exampleName" v-model="form.name" placeholder="Full Name">
                      <small class="text-danger font-weight-bold" v-if="errors.name">{{ errors.name[0] }}</small>
                    </div>
                    <div class="form-group row">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" v-model="form.email" placeholder="Email Address">
                      <small class="text-danger font-weight-bold" v-if="errors.email">{{ errors.email[0] }}</small>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="password" class="form-control form-control-user" id="exampleInputPassword" v-model="form.password" placeholder="Password" autocomplete="new-password">
                        <small class="text-danger font-weight-bold" v-if="errors.password">{{ errors.password[0] }}</small>
                      </div>
                      <div class="col-sm-6">
                        <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" v-model="form.password_confirmation" placeholder="Repeat Password" autocomplete="new-password">
                        <small class="text-danger font-weight-bold" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</small>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Register Account
                    </button>
                  </form>
                    <br><hr><br>
                  <div class="text-center">
                    <router-link to="/" class="btn btn-success">Already have an account? Login!</router-link>
                  </div>
                  <div class="text-center">
                    <router-link to="/forget" class="small">Forgot Password?</router-link>
                  </div>
                  <br><hr>
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
        name: null,
        email: null,
        password: null
      },
      errors:{}
    }
  },

  methods:{
    register(){
      axios.post('/api/auth/register',this.form)
      .then(res => {
        User.responseAfterLogin(res)

        Toast.fire({
          icon: 'success',
          title: 'Signup Successfull !!'
        })

        this.$router.push({ name: 'home' })
      })
      .catch(error => {
        this.errors = error.response.data.errors

        Toast.fire({
          icon: 'error',
          title: 'Invalid Credential !!'
        })

      })
    }
  }

}
</script>

<style type="text/css">
	
</style>