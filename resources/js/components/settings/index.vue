<template>
    <div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
        <!-- Icon Cards-->
       <div class="card shadow mb-4">
            <div class="card-header py-3">
				<span class="m-0 font-weight-bold text-primary">
					<i class="fas fa-chart-area"></i>
            		Settings Update 
				</span>
            <router-link to="/home" class="btn btn-sm btn-info" id="add_new"> Dashboard</router-link>
          </div>
          <div class="card-body">
          	  <form @submit.prevent="settingsInsert">
                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12 m-auto">
	                <div class="form-label-group">
	                  <label for="fullName">Vat</label><span class="text-danger">*</span>
                      <div class="row">
	                  <input type="number" step="any" v-model="form.vat" class="form-control col-md-4"  >
                      <span class="form-control col-md-1">%</span>
                      </div>
	                  <!-- <small class="text-danger" v-if="errors.vat">{{ errors.vat[0] }}</small> -->
	                </div>
					<br>
               <button type="submit" class="btn btn-success m-auto">Submit</button>
	               </div>
	             </div>
	          </div>

              </form>
          </div>
          <br>
         </div>
       </div>
   </div>
</template>



<script type="text/javascript">
 export default { 

      created(){
            if(!User.loggedIn()){
              this.$router.push({ name: '/' })
            }else{
              this.allSettings(),
              this.addSettings()
            }
      },

      data(){
          return{
              form:{
                  vat :'',
              },
          }
      },

      methods:{
        allSettings(){
          axios.get('/api/settings/')
          .then( ({data}) => {
              this.form.vat = data.vat
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        settingsInsert(){
        axios.post('/api/settings/',this.form)
        .then(() => {
            this.$router.push({ name: 'settings' })
            Toast.fire({
                icon: 'success',
                title: 'Settings Added Successfully!'
            })
        })
       .catch(error => {
        this.errors = error.response.data.errors

        Toast.fire({
          icon: 'error',
          title: 'Invalid Credentials !!'
        })

      })

    },
        

      }

  }
</script>



<style type="text/css">
	
  #imgstyle{
    height: 50px;
    border: 1px solid rgb(209 211 225);
    border-radius: 10%;
  }
  .dataTables_empty{
    display: none;
  }

</style>