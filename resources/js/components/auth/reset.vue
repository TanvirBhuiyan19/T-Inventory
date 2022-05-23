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
                    <h1 class="h4 text-gray-900 mb-4">Set New Password !</h1>
                  </div>
                  <form class="user" @submit.prevent="resetPassword">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" v-model="form.email" placeholder="Email Address">
                      <small class="text-danger font-weight-bold" v-if="errors.email">{{ errors.email[0] }}</small>
                      
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="password" class="form-control form-control-user" id="exampleInputPassword" v-model="form.password" placeholder="New Password" autocomplete="new-password">
                        <small class="text-danger font-weight-bold" v-if="errors.password">{{ errors.password[0] }}</small>
                      </div>
                      <div class="col-sm-6">
                        <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" v-model="form.password_confirmation" placeholder="Repeat Password" autocomplete="new-password">
                        <small class="text-danger font-weight-bold" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</small>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Set Password
                    </button>
                  </form>

                  <br><br><hr><br>
                  <div class="text-center">
                    <router-link to="/" class="btn btn-success">Back to Login</router-link>
                  </div>
                  <br><hr><br>

                </div>
              </div>
            </div>
          </div>
        </div>
      <br><br>
      </div>
    </div>
  </div>
</div>

</template>

<script type="text/javascript">
 export default { 
   created(){
     this.form.resetToken = this.$route.params.token
   },
  data(){
    return{
      form:{
        email: null,
        password: null,
        password_confirmation: null,
        resetToken: null
      },
      errors:{}
    }
  },

  methods:{
    resetPassword(){
      axios.post('/api/auth/resetPassword',this.form)
      .then(() => {
        Toast.fire({
          icon: 'success',
          title: 'Password Change Successfully !!'
        })

        this.$router.push({ name: '/' })
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