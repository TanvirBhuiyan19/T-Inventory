 <template>
    <div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link to="/category">All Category</router-link>
          </li>
          <li class="breadcrumb-item active">Edit Category</li>
        </ol>
        <!-- Icon Cards-->
       <div class="card shadow mb-4">
            <div class="card-header py-3">
				<span class="m-0 font-weight-bold text-primary">
					<i class="fas fa-chart-area"></i>
            		Category Update 
				</span>
            <router-link to="/category" class="btn btn-sm btn-info" id="add_new"> All Category</router-link>
          </div>
          <div class="card-body">
          	  <form @submit.prevent="employeeUpdate">
                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12 m-auto">
	                <div class="form-label-group">
	                  <label for="fullName">Category Name</label><span class="text-danger">*</span>
	                  <input type="text" v-model="form.name" class="form-control"  >
	                  <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
	                </div>
					<br>
               <button type="submit" class="btn btn-success m-auto">Update Category</button>
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
  
	data(){
		return{
			form:{
				name :'',
			},
			errors:{},
		}
  	},
   created(){
     if(!User.loggedIn()){
       this.$router.push({ name: '/' })
     }else{
         let id = this.$route.params.id
         axios.get('/api/category/'+id)
         .then(({data}) => {
             this.form = data
         })

     }
   	},

  	methods:{

		employeeUpdate(){
			let id = this.$route.params.id
			axios.patch('/api/category/'+id,this.form)
			.then(() => {
				this.$router.push({ name: 'category' })
				Toast.fire({
					icon: 'success',
					title: 'Category Update Successfully!'
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

	#add_new{
	float: right;
}

</style>