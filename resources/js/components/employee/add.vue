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
            <router-link to="/employee">All Employee</router-link>
          </li>
          <li class="breadcrumb-item active">Add Employee</li>
        </ol>
        <!-- Icon Cards-->
       <div class="card shadow mb-4">
            <div class="card-header py-3">
				<span class="m-0 font-weight-bold text-primary">
					<i class="fas fa-chart-area"></i>
            		Employee Insert 
				</span>
            <router-link to="/employee" class="btn btn-sm btn-info" id="add_new"> All Employee</router-link>
          </div>
          <div class="card-body">
          	  <form @submit.prevent="employeeInsert" enctype="multipart/form-data">
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
	                  <label for="email">Email Address</label><span class="text-danger">*</span>
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
	                  <label for="address">Address</label><span class="text-danger">*</span>
	                  <input type="text" v-model="form.address" class="form-control" >
	                  <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="salary">Salary</label><span class="text-danger">*</span>
	                  <input type="number" v-model="form.salary" class="form-control" >
	                  <small class="text-danger" v-if="errors.salary">{{ errors.salary[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
	          <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-4 col-sm-12">
	                <div class="form-label-group">
	                  <label for="joiningDate">Joining Date</label><span class="text-danger">*</span>
	                  <input type="date" v-model="form.joining_date" class="form-control"  autofocus="autofocus" >
	                  <small class="text-danger" v-if="errors.joining_date">{{ errors.joining_date[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-4 col-sm-12">
	                <div class="form-label-group">
	                  <label for="nid">NID Number</label>
	                  <input type="text" v-model="form.nid" class="form-control"  >
	                  <small class="text-danger" v-if="errors.nid">{{ errors.nid[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-4 col-sm-12">
	                <div class="form-label-group">
	                  <label for="phone">Phone Number</label><span class="text-danger">*</span>
	                  <input type="text" v-model="form.phone" class="form-control" >
	                  <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
               <div class="form-group">
	              <div class="form-row">
	               

	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
					<label for="photo">Photo</label><br>
	                 <input type="file" class="btn btn-info btn-sm" accept="image/*" @change="onFileSelected" >
	                  <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
	                </div>
	               </div>
	                <div class="col-md-6 col-sm-12">
	                	<img :src="form.photo" style="height: 70px; width: auto; border: 2px solid #D1D3E2;" >
	                </div>
	             </div>
	          </div>

               <button type="submit" class="btn btn-success">Submit</button>
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
     }
   },
  data(){
    return{
      form:{
        name :'',
        email :'',
        salary:'',
        address:'',
        photo :'',
        phone:'',
        nid : '',
        joining_date:''
    },
      errors:{},
    }
  },

  methods:{

	employeeInsert(){
        axios.post('/api/employee/',this.form)
        .then(() => {
            this.$router.push({ name: 'employee' })
            Toast.fire({
                icon: 'success',
                title: 'Employee Added Successfully!'
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