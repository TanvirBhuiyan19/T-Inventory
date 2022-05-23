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
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                  </div>
                  <form class="user" @submit.prevent="forgetPassword">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" v-model="form.email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                      <small class="text-danger font-weight-bold" v-if="errors.email">{{ errors.email[0] }}</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Reset Password
                    </button>
                  </form>
                  <br><hr><br>
                  <div class="text-center">
                    <router-link to="/" class="btn btn-success">Already have an account? Login!</router-link>
                  </div>
                  <br>
                  <div class="text-center">
                    <router-link to="/register" class="btn btn-info">Create an Account!</router-link>
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
        email: null
      },
      errors:{},
    }
  },

  methods:{
    forgetPassword(){
      axios.post('/api/auth/sendPasswordResetLink',this.form)
      .then( () => {
        Toast.fire({
          icon: 'success',
          title: 'Reset Email is send successfully, please check your inbox.'
        })

        this.$router.push({ name: '/' })
      })
      .catch(error => {
        this.errors = error.response.data.errors

        Toast.fire({
          icon: 'error',
          title: 'Email does\'t found on our database!!'
        })

      })
    }
  }



  }
</script>

<style type="text/css">
	
</style>