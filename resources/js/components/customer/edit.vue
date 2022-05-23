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
            <router-link to="/customer">All Customer</router-link>
          </li>
          <li class="breadcrumb-item active">Edit Customer</li>
        </ol>
        <!-- Icon Cards-->
       <div class="card shadow mb-4">
            <div class="card-header py-3">
				<span class="m-0 font-weight-bold text-primary">
					<i class="fas fa-chart-area"></i>
            		Customer Update 
				</span>
            <router-link to="/customer" class="btn btn-sm btn-info" id="add_new"> All Customer</router-link>
          </div>
          <div class="card-body">
          	  <form @submit.prevent="customerUpdate" enctype="multipart/form-data">
                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="fullName">Full Name</label><span class="text-danger">*</span>
	                  <input type="text" v-model="form.name" class="form-control"  >
	                  <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="email">Email Address</label>
	                  <input type="email" v-model="form.email" class="form-control" >
	                  <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
	          <div class="form-group">
	              <div class="form-row">
					<div class="col-md-6 col-sm-12">
						<div class="form-label-group">
						<label for="phone">Phone Number</label><span class="text-danger">*</span>
						<input type="text" v-model="form.phone" class="form-control" >
						<small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
						</div>
					</div>
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="address">Address</label><span class="text-danger">*</span>
	                  <input type="text" v-model="form.address" class="form-control" >
	                  <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
	                </div>
	               </div>
	               
	             </div>
	          </div>
               <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
					<label for="phone">Photo</label><br>
	                 <input type="file" class="btn btn-info btn-sm" accept="image/*" @change="onFileSelected" >
	                  <small class="text-danger" v-if="errors.newPhoto">{{ errors.newPhoto[0] }}</small>
	                </div>
	               </div>
	                <div class="col-md-3 col-sm-6">
                        <label for="phone">New Photo</label><br>
	                	<img :src="form.photo" style="height: 70px; width: auto; border: 2px solid #D1D3E2;" >
	                </div>
	                <div class="col-md-3 col-sm-6">
                        <label for="phone">Old Photo</label><br>
	                	<img :src="'/backend/uploads/customer/' + form.oldPhoto" style="height: 70px; width: auto; border: 2px solid #D1D3E2;" >
	                </div>
	             </div>
	          </div>

               <button type="submit" class="btn btn-success">Update</button>
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
        email :'',
        address:'',
        photo :'',
        oldPhoto :'',
        phone:'',
    },
      errors:{},
    }
  },
   created(){
     if(!User.loggedIn()){
       this.$router.push({ name: '/' })
     }else{
         let id = this.$route.params.id
         axios.get('/api/customer/'+id)
         .then(({data}) => {
             this.form = data
            this.form.oldPhoto = data.photo
         })
         .catch(console.log('error') )

     }
   },

  methods:{

	customerUpdate(){
		let id = this.$route.params.id
        axios.patch('/api/customer/'+id,this.form)
        .then(() => {
            this.$router.push({ name: 'customer' })
            Toast.fire({
                icon: 'success',
                title: 'Customer Update Successfully!'
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

	onFileSelected(event){
		let file = event.target.files[0]
		if(file.size > 1048576 ){
			Toast.fire({
				icon: 'error',
				title: 'Image size have to less then 1MB'
			})

		}else{
			let reader = new FileReader();
			reader.onload = event => {
				this.form.photo = event.target.result
			}
			reader.readAsDataURL(file)
			
		}

	}


  }


}
</script>

<style type="text/css">

	#add_new{
	float: right;
}

</style>